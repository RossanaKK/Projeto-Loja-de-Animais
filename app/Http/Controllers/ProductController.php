<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return $this->indexByCategory(0, $request);
    }

    public function indexByCategory($id, Request $request = null)
    {
        $request = $request ?? request();
        $categorias = Category::all();
        $ordem = $request->query('ordem');
        $pesquisa = $request->query('pesquisa');
        $categoriaId = $request->query('category', $id);

        $query = Product::with('category');

        if ($categoriaId != 0) {
            $query->where('category_id', $categoriaId);
        }

        if (!empty($pesquisa)) {
            $query->where(function ($q) use ($pesquisa) {
                $q->where('name', 'like', '%' . $pesquisa . '%')
                  ->orWhere('description', 'like', '%' . $pesquisa . '%');
            });
        }

        if ($ordem === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($ordem === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $produtos = $query->get();

        return view('products.index', [
            'products' => $produtos,
            'categorias' => $categorias,
            'idCategoriaAtiva' => $categoriaId,
            'ordem' => $ordem,
            'pesquisa' => $pesquisa,
        ]);
    }

    public function show($id)
    {
        $produto = Product::findOrFail($id);
        $categoria = Category::find($produto->category_id);

        return view('products.show', [
            'produto' => $produto,
            'categoria' => $categoria,
        ]);
    }

    public function create()
    {
        if (!Auth::user()?->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $categorias = Category::all();
        return view('products.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()?->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image',
            'image' => 'nullable|string',
        ]);

        $imageUrl = $request->image;

        if ($request->hasFile('image_file')) {
            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
            $resultado = $cloudinary->uploadApi()->upload($request->file('image_file')->getRealPath(), [
                'upload_preset' => 'lojaanimais_preset',
            ]);
            $imageUrl = $resultado['secure_url'];
        }

        $produto = new Product();
        $produto->name = $request->name;
        $produto->description = $request->description;
        $produto->price = $request->price;
        $produto->category_id = $request->category_id;
        $produto->image = $imageUrl;
        $produto->owner_id = Auth::id();
        $produto->save();

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit($id)
    {
        if (!Auth::user()?->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $produto = Product::findOrFail($id);
        $categorias = Category::all();

        return view('products.edit', [
            'produto' => $produto,
            'categorias' => $categorias,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()?->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image',
            'image' => 'nullable|string',
        ]);

        $produto = Product::findOrFail($id);
        $produto->name = $request->name;
        $produto->description = $request->description;
        $produto->price = $request->price;
        $produto->category_id = $request->category_id;

        if ($request->hasFile('image_file')) {
            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
            $resultado = $cloudinary->uploadApi()->upload($request->file('image_file')->getRealPath(), [
                'upload_preset' => 'lojaanimais_preset',
            ]);
            $produto->image = $resultado['secure_url'];
        } elseif ($request->filled('image')) {
            $produto->image = $request->image;
        }

        $produto->save();

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        if (!Auth::user()?->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $produto = Product::findOrFail($id);
        $produto->delete();

        return redirect()->route('products.index')->with('success', 'Produto eliminado com sucesso!');
    }
}
