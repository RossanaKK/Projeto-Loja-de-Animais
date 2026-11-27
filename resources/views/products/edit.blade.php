@extends('layouts.main')

@section('content')
<div class="container-loja" style="padding: 20px; max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('products.index') }}" class="button">← Voltar aos Produtos</a>
    </div>

    <h1>Editar Produto: {{ $produto->name }}</h1>

    @if ($errors->any())
        <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>Por favor, corrige os seguintes erros:</strong>
            <ul style="margin: 10px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $produto->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px; background: #fff; padding: 25px; border-radius: 10px; border: 1px solid #ddd;">
        @csrf
        @method('PUT')

        <div>
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Nome do Produto *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $produto->name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
            @error('name')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="category_id" style="display: block; font-weight: bold; margin-bottom: 5px;">Categoria *</label>
            <select id="category_id" name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('category_id', $produto->category_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price" style="display: block; font-weight: bold; margin-bottom: 5px;">Preço (€) *</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $produto->price) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
            @error('price')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 5px;">Descrição</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">{{ old('description', $produto->description) }}</textarea>
            @error('description')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Imagem Atual</label>
            <img src="{{ $produto->image ? (Str::startsWith($produto->image, 'http') ? $produto->image : asset($produto->image)) : asset('img/sem-foto.jpg') }}"
                 alt="{{ $produto->name }}"
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="image_file" style="display: block; font-weight: bold; margin-bottom: 5px;">Substituir por Nova Imagem</label>
            <input type="file" id="image_file" name="image_file" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
            @error('image_file')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image" style="display: block; font-weight: bold; margin-bottom: 5px;">Ou Alterar URL da Imagem</label>
            <input type="text" id="image" name="image" value="{{ old('image', $produto->image) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
            @error('image')
                <span style="color: #dc2626; font-size: 0.85rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="button" style="padding: 12px; font-weight: bold; cursor: pointer;">Atualizar Produto</button>
    </form>
</div>
@endsection
