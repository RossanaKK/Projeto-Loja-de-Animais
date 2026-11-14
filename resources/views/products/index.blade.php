@extends('layouts.main')

@section('content')
<div class="container-loja" style="padding: 20px;">
    <h1>Produtos da Loja</h1>

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

    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <div>
            <strong>Filtrar por Categoria:</strong>
            <a href="{{ route('products.index') }}" class="button" style="padding: 5px 10px; font-size: 0.9rem;">Todas</a>
            @foreach($categorias as $cat)
                <a href="{{ route('categories.products', $cat->id) }}" class="button" style="padding: 5px 10px; font-size: 0.9rem;">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div>
            <strong>Ordenar por Preço:</strong>
            <a href="{{ route('products.index', ['ordem' => 'asc']) }}" class="button" style="padding: 5px 10px; font-size: 0.9rem;">
                Preço ↑ (Menor)
            </a>
            <a href="{{ route('products.index', ['ordem' => 'desc']) }}" class="button" style="padding: 5px 10px; font-size: 0.9rem;">
                Preço ↓ (Maior)
            </a>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('products.create') }}" class="button" style="margin-bottom: 20px; display:inline-block;">Criar Produto</a>
    @endif

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <table class="tabela-loja" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #112222; color: white; text-align: left;">
                <th style="padding: 10px;">IMAGEM</th>
                <th style="padding: 10px;">NOME</th>
                <th style="padding: 10px;">CATEGORIA</th>
                <th style="padding: 10px;">PREÇO</th>
                <th style="padding: 10px; text-align: right;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">
                    @if($product->image)
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    @endif
                </td>
                <td style="padding: 10px;">
                    <a href="{{ route('products.show', $product->id) }}" style="font-weight: bold; color: #0f766e;">
                        {{ $product->name }}
                    </a>
                </td>
                <td style="padding: 10px;">
                    @if($product->category)
                        <a href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name }}</a>
                    @endif
                </td>
                <td style="padding: 10px;">{{ number_format($product->price, 2, ',', '.') }} €</td>
                <td style="padding: 10px; text-align: right;">
                    <a href="{{ route('products.show', $product->id) }}" style="margin-right: 10px;">Detalhes</a>
                    @if(Auth::check() && Auth::user()->is_admin)
                        <a href="{{ route('products.edit', $product->id) }}" style="margin-right: 10px;">Editar</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tens a certeza que queres eliminar?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">Eliminar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
