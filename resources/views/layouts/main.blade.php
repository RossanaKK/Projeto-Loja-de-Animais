<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Loja de Animais')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
</head>
<body>

    <nav class="navbar-loja">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="brand-logo">
                <span>🐾 Loja de Animais</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('home') }}">Catálogo</a>

                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('products.index') }}">Produtos</a>
                    <a href="{{ route('categories.index') }}">Categorias</a>
                    <a href="{{ route('pets.index') }}">Os Meus Animais</a>
                    <a href="{{ route('orders.index') }}">Encomendas</a>
                    <a href="{{ route('contact') }}">Contacto</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); submitForm('logout-form');" class="btn-loja btn-destaque">
                        Sair ({{ Auth::user()->name }})
                    </a>
                @else
                    <a href="{{ route('contact') }}">Contacto</a>
                    <a href="{{ route('login') }}">Entrar</a>
                    <a href="{{ route('register') }}" class="btn-loja">Criar Conta</a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer-loja">
        <p><strong>🐾 Loja de Animais</strong> — Rua da Universidade, Funchal | Email: contacto@lojaanimais.pt | Tel: 291 000 000</p>
        <p>&copy; {{ date('Y') }} Projeto de Aplicações Centradas em Redes</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
