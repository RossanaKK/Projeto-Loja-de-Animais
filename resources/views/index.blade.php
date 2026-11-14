@extends('layouts.main')

@section('title', 'Loja de Animais — Catálogo')

@section('content')

    <header class="hero-banner">
        <h1>Tudo o que o teu melhor amigo precisa</h1>
        <p>Explora a nossa seleção de alimentação, brinquedos, acessórios e higiene para cães e gatos.</p>
    </header>

    <main class="container-loja">

        <div class="filtros-categorias">
            <strong>Filtrar por categoria:</strong>
            <a href="{{ route('home') }}" class="filtro-pill {{ !request('category') ? 'ativo' : '' }}">
                Todas
            </a>
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}"
                   class="filtro-pill {{ request('category') == $category->id ? 'ativo' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <p>Não existem produtos disponíveis nesta categoria de momento.</p>
        @else
            <div class="grelha-produtos">
                @foreach($products as $product)
                    <div class="cartao-produto">
                        <div>
                            <div class="produto-imagem">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/sem-foto.png') }}" alt="Sem imagem">
                                @endif
                            </div>

                            <div class="produto-corpo">
                                <span class="badge-categoria">{{ $product->category->name }}</span>
                                <h2 class="produto-titulo">{{ $product->name }}</h2>
                                <p class="produto-descricao">
                                    {{ $product->description ?? 'Artigo selecionado para o bem-estar do teu animal.' }}
                                </p>
                            </div>
                        </div>

                        <div class="produto-rodape">
                            <span class="produto-preco">{{ number_format($product->price, 2, ',', '.') }} €</span>

                            @auth
                                <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" class="btn-loja">
                                    Encomendar
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-loja btn-destaque">
                                    Comprar
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
