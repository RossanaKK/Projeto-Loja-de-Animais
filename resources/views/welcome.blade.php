@extends('layouts.main')

@section('content')
<main class="hero-inicio">
    <h1>Bem-vindo à Loja de Animais!</h1>
    <p>Encontra os melhores produtos, alimentação, brinquedos e acessórios para o teu animal de estimação.</p>
    <a href="{{ route('products.index') }}" class="btn-loja">Ver Catálogo de Produtos</a>
</main>
@endsection
