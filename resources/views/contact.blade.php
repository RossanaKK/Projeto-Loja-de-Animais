@extends('layouts.main')

@section('title', 'Loja de Animais — Contacto')

@section('content')
    <main class="container-loja" style="max-width: 700px;">
        <div class="cartao-produto" style="padding: 2rem;">
            <h1 style="margin-top: 0; color: var(--cor-primaria);">Contacta-nos</h1>
            <p style="color: var(--cor-texto-suave);">
                Tens alguma dúvida sobre os nossos produtos ou encomendas? Envia-nos uma mensagem ou contacta-nos diretamente através do email <strong>contacto@loja.pt</strong>.
            </p>

            @if(session('success'))
                <div class="alerta-sucesso" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.3rem;">O teu Nome</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--cor-borda); border-radius: 8px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.3rem;">O teu Email</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--cor-borda); border-radius: 8px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.3rem;">Mensagem</label>
                    <textarea name="message" rows="4" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--cor-borda); border-radius: 8px;"></textarea>
                </div>

                <div>
                    <button type="submit" class="btn-loja">Enviar Mensagem</button>
                </div>
            </form>
        </div>
    </main>
@endsection
