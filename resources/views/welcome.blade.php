@extends('layouts.main')

@section('content')
    <main class="container-loja" style="text-align: center; max-width: 700px; padding: 4rem 1rem;">
        <h1>Bem-vindo à Loja de Animais!</h1>
        <p style="font-size: 1.1rem; color: #cbd5e1; margin: 1.5rem 0;">
            Encontra os melhores produtos, alimentação, brinquedos e acessórios para o teu animal de estimação.
        </p>

        <div style="margin-top: 2rem;">
            <a href="{{ route('products.index') }}" class="button" style="padding: 0.75rem 2rem; font-size: 1.1rem; text-decoration: none; display: inline-block;">
                Ver Catálogo de Produtos
            </a>
        </div>
    </main>
@endsection
