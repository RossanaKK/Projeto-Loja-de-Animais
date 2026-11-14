@extends('layouts.main')

@section('content')
<div class="container-loja" style="padding: 20px;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('products.index') }}" class="button">← Voltar aos Produtos</a>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; background: #fff; padding: 25px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 30px;">
        <div style="flex: 1; min-width: 280px; max-width: 450px;">
            <img src="{{ $produto->image ? (Str::startsWith($produto->image, 'http') ? $produto->image : asset($produto->image)) : asset('img/sem-foto.jpg') }}"
                 alt="{{ $produto->name }}"
                 style="width: 100%; height: auto; max-height: 400px; object-fit: cover; border-radius: 8px;">
        </div>

        <div style="flex: 2; min-width: 280px;">
            @if($categoria)
                <a href="{{ route('categories.show', $categoria->id) }}" style="background: #e6fffa; color: #0f766e; padding: 4px 10px; border-radius: 5px; font-size: 0.85rem; font-weight: bold;">
                    {{ $categoria->name }}
                </a>
            @endif

            <h1 style="margin: 10px 0;">{{ $produto->name }}</h1>
            <p style="font-size: 1.6rem; font-weight: bold; color: #0f766e; margin: 15px 0;">
                {{ number_format($produto->price, 2, ',', '.') }} €
            </p>
            <p style="line-height: 1.6; color: #444; margin-bottom: 25px;">
                {{ $produto->description ?? 'Sem descrição disponível.' }}
            </p>

            @if(Auth::check() && Auth::user()->is_admin)
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('products.edit', $produto->id) }}" class="button">Editar Produto</a>
                    <form action="{{ route('products.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres eliminar este produto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button" style="background-color: #dc2626; color: white; border: none; cursor: pointer;">Eliminar</button>
                    </form>
                </div>
            @elseif(Auth::check())
                <form action="{{ route('orders.store') }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $produto->id }}">
                    <input type="number" name="quantity" value="1" min="1" style="width: 70px; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                    <button type="submit" class="button">Comprar Agora</button>
                </form>
            @else
                <p style="color: #666;">Faz <a href="{{ route('login') }}" style="color: #0f766e; font-weight: bold;">login</a> para comprar este produto.</p>
            @endif
        </div>
    </div>

    @isset($destaque)
        <div style="background: #f0fdfa; border: 1px solid #0f766e; border-radius: 8px; padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
            <img src="{{ $destaque->image ? (Str::startsWith($destaque->image, 'http') ? $destaque->image : asset($destaque->image)) : asset('img/sem-foto.jpg') }}"
                 alt="{{ $destaque->name }}"
                 style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;">
            <div>
                <span style="background: #0f766e; color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">Destaque Aleatório</span>
                <h3 style="margin: 5px 0;">{{ $destaque->name }} — {{ number_format($destaque->price, 2, ',', '.') }} €</h3>
                <a href="{{ route('products.show', $destaque->id) }}" style="color: #0f766e; font-weight: bold;">Ver produto →</a>
            </div>
        </div>
    @endisset
</div>
@endsection
