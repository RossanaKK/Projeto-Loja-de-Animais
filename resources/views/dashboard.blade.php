@extends('layouts.main')

@section('content')
    <main class="container-loja" style="max-width: 650px;">
        <h1>Painel de Controlo</h1>

        <div id="dashboardBox" class="form-box">
            <p>Olá, <strong>{{ Auth::user()->name }}</strong>!</p>

            <div class="dashboard-links" style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1.5rem;">
                <a href="{{ route('products.index') }}" class="button">
                    Ver Produtos
                </a>

                @if(Auth::user()->is_admin)
                    <a href="{{ route('products.create') }}" class="button">
                        Criar Produto
                    </a>
                    <a href="{{ route('categories.index') }}" class="button">
                        Gerir Categorias
                    </a>
                    <a href="{{ route('categories.create') }}" class="button">
                        Criar Categoria
                    </a>
                @else
                    <a href="{{ route('orders.index') }}" class="button">
                        As Minhas Encomendas
                    </a>
                    <a href="{{ route('pets.index') }}" class="button">
                        Os Meus Animais
                    </a>
                @endif
            </div>
        </div>
    </main>
@endsection
