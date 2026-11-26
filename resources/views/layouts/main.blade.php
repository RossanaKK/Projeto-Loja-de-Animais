<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Animais</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=15">
</head>
<body style="background: linear-gradient(rgba(250, 248, 245, 0.22), rgba(250, 248, 245, 0.30)), url('{{ asset('img/loja.jpg') }}') center/cover fixed no-repeat;">
    <header class="navbar-loja">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="brand-logo">🐾 Loja de Animais</a>

            <nav class="nav-links">
                <a href="{{ route('products.index') }}">Catálogo</a>

                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <a href="{{ route('products.index') }}">Produtos</a>
                    <a href="{{ route('categories.index') }}">Categorias</a>
                    @if(!Auth::user()->is_admin)
                        <a href="{{ route('pets.index') }}">Os Meus Animais</a>
                    @endif
                    <a href="{{ route('orders.index') }}">Encomendas</a>
                @endauth

                <a href="{{ url('/contacto') }}">Contacto</a>

                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-loja btn-destaque">
                            Sair ({{ Auth::user()->name }})
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Entrar</a>
                    <a href="{{ route('register') }}" class="btn-loja">Criar Conta</a>
                @endauth
            </nav>
        </div>
    </header>

    <div class="app-wrapper">
        @yield('content')
    </div>

    <footer class="footer-loja">
        <p>🐾 <strong>Loja de Animais</strong> — Rua da Universidade, Funchal | Email: contacto@loja.pt | Tel: 291 123 456</p>
        <p>© 2026 Projeto de Aplicações Centradas em Redes - Realizado por Rossana Kiekeben</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
