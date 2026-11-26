<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function getCloudinaryInstance(): Cloudinary
    {
        if (env('CLOUDINARY_URL')) {
            return new Cloudinary(env('CLOUDINARY_URL'));
        }

        return new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function index(Request $request)
    {
        return $this->indexByCategory(0, $request);
    }

    public function indexByCategory($id, Request $request = null)
    {
        $request = $request ?? request();
        $categorias = Category::all();
        $destaque = Product::inRandomOrder()->first();
        $ordem = $request->query('ordem');
        $pesquisa = $request->query('pesquisa');

        $query = Product::with('category');

        if ($id != 0) {
            $query->where('category_id', $id);
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
            'idCategoriaAtiva' => $id,
            'destaque' => $destaque,
            'ordem' => $ordem,
            'pesquisa' => $pesquisa,
        ]);
    }

    public function show($id)
    {
        $produto = Product::findOrFail($id);
        $categoria = Category::find($produto->category_id);
        $destaque = Product::inRandomOrder()->first();

        return view('products.show', [
            'produto' => $produto,
            'categoria' => $categoria,
            'destaque' => $destaque,
        ]);
    }

    public function create()
    {
        if (! Auth::user()->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $categorias = Category::all();
        return view('products.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        if (! Auth::user()->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:5',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image' => 'nullable|string|max:500',
        ], [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.min' => 'O nome do produto deve ter pelo menos 3 caracteres.',
            'description.min' => 'A descrição deve ter pelo menos 5 caracteres.',
            'price.required' => 'Indica o preço do produto.',
            'price.numeric' => 'O preço tem de ser um valor numérico válido.',
            'price.min' => 'O preço deve ser superior a 0 €.',
            'category_id.required' => 'Seleciona uma categoria para o produto.',
            'category_id.exists' => 'A categoria selecionada não é válida.',
            'image_file.image' => 'O ficheiro enviado tem de ser uma imagem.',
            'image_file.mimes' => 'A imagem deve estar no formato JPG, JPEG, PNG ou WEBP.',
            'image_file.max' => 'A imagem não pode ultrapassar os 2MB.',
        ]);

        $imageUrl = $request->image;

        if ($request->hasFile('image_file')) {
            $cloudinary = $this->getCloudinaryInstance();
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
        if (! Auth::user()->isAdmin) {
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
        if (! Auth::user()->isAdmin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:5',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image' => 'nullable|string|max:500',
        ], [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.min' => 'O nome do produto deve ter pelo menos 3 caracteres.',
            'description.min' => 'A descrição deve ter pelo menos 5 caracteres.',
            'price.required' => 'Indica o preço do produto.',
            'price.numeric' => 'O preço tem de ser um valor numérico válido.',
            'price.min' => 'O preço deve ser superior a 0 €.',
            'category_id.required' => 'Seleciona uma categoria para o produto.',
            'category_id.exists' => 'A categoria selecionada não é válida.',
            'image_file.image' => 'O ficheiro enviado tem de ser uma imagem.',
            'image_file.mimes' => 'A imagem deve estar no formato JPG, JPEG, PNG ou WEBP.',
            'image_file.max' => 'A imagem não pode ultrapassar os 2MB.',
        ]);

        $produto = Product::findOrFail($id);
        $produto->name = $request->name;
        $produto->description = $request->description;
        $produto->price = $request->price;
        $produto->category_id = $request->category_id;

        if ($request->hasFile('image_file')) {
            $cloudinary = $this->getCloudinaryInstance();
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
        if (! Auth::user()->is_admin) {
            return redirect()->route('products.index')->with('error', 'Acesso reservado a administradores.');
        }

        $produto = Product::findOrFail($id);
        $produto->delete();

        return redirect()->route('products.index')->with('success', 'Produto eliminado com sucesso!');
    }
}
