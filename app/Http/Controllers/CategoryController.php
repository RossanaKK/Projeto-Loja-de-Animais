<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $categoria = Category::with('products')->findOrFail($id);
        return view('categories.show', compact('categoria'));
    }

    public function create()
    {
        if (! Auth::user()->isAdmin) {
            return redirect()->route('categories.index')->with('error', 'Acesso reservado a administradores.');
        }

        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (! Auth::user()->isAdmin) {
            return redirect()->route('categories.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:categories,name',
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.min' => 'O nome da categoria deve ter pelo menos 3 caracteres.',
            'name.unique' => 'Já existe uma categoria com esse nome.',
        ]);

        $categoria = new Category();
        $categoria->name = $request->name;
        $categoria->save();

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        if (! Auth::user()->isAdmin) {
            return redirect()->route('categories.index')->with('error', 'Acesso reservado a administradores.');
        }

        $categoria = Category::findOrFail($id);
        return view('categories.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        if (! Auth::user()->isAdmin) {
            return redirect()->route('categories.index')->with('error', 'Acesso reservado a administradores.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:categories,name,' . $id,
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.min' => 'O nome da categoria deve ter pelo menos 3 caracteres.',
            'name.unique' => 'Já existe outra categoria com esse nome.',
        ]);

        $categoria = Category::findOrFail($id);
        $categoria->name = $request->name;
        $categoria->save();

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        if (! Auth::user()->isAdmin) {
            return redirect()->route('categories.index')->with('error', 'Acesso reservado a administradores.');
        }

        $categoria = Category::find($id);
        $categoria->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria eliminada com sucesso!');
    }
}
