@extends('layouts.main')

@section('content')
    <main class="container-loja">
        <div class="cabecalho-seccao">
            <h1>Os Meus Animais</h1>
            <a href="{{ route('pets.create') }}" class="btn-loja">+ Registar Animal</a>
        </div>

        @if(session('success'))
            <div class="alerta-sucesso">{{ session('success') }}</div>
        @endif

        <div class="tabela-contentor">
            @if($pets->isEmpty())
                <p style="padding: 1.5rem;">Ainda não tens animais registados na tua conta.</p>
            @else
                <table class="tabela-loja">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Espécie</th>
                            <th>Raça</th>
                            <th style="text-align: right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pets as $pet)
                            <tr>
                                <td><strong>{{ $pet->name }}</strong></td>
                                <td>{{ $pet->species }}</td>
                                <td>{{ $pet->breed ?? '-' }}</td>
                                <td style="text-align: right;">
                                    <a href="{{ route('pets.edit', $pet->id) }}" class="link-editar">Editar</a>
                                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Remover este animal?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
@endsection
