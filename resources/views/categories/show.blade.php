@extends('layouts.main')

@section('content')
<div class="container-loja" style="padding: 20px;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('categories.index') }}" class="button">← Voltar às Categorias</a>
    </div>

    <h1>Categoria: {{ $categoria->name }}</h1>
    <p>Total de produtos nesta categoria: <strong>{{ $categoria->products->count() }}</strong></p>

    <hr style="margin: 20px 0;">

    <h2>Produtos desta Categoria</h2>

    @if($categoria->products->isEmpty())
        <p>Ainda não existem produtos registados nesta categoria.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 15px;">
            @foreach($categoria->products as $produto)
                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #fff;">
                    <img src="{{ $produto->image ? (Str::startsWith($produto->image, 'http') ? $produto->image : asset($produto->image)) : asset('img/sem-foto.jpg') }}"
                         alt="{{ $produto->name }}"
                         style="width: 100%; height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 10px;">
                    <h3>{{ $produto->name }}</h3>
                    <p style="font-weight: bold; color: #0f766e;">{{ number_format($produto->price, 2, ',', '.') }} €</p>
                    <a href="{{ route('products.show', $produto->id) }}" class="button" style="display: inline-block; margin-top: 10px;">Ver Detalhes</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
