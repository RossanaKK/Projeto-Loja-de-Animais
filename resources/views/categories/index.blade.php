@extends('layouts.main')

@section('content')
    <main class="container-loja">
        <div class="cabecalho-seccao">
            <h1>Categorias</h1>
            @if(Auth::user()->is_admin)
                <a href="{{ route('categories.create') }}" class="btn-loja">+ Nova Categoria</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alerta-sucesso">{{ session('success') }}</div>
        @endif

        <div class="tabela-contentor">
            <table class="tabela-loja">
                <thead>
                    <tr>
                        <th>Nome da Categoria</th>
                        <th>Nº de Produtos</th>
                        @if(Auth::user()->is_admin)
                            <th style="text-align: right;">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>
                                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="link-editar">
                                    {{ $category->products->count() }}
                                </a>
                            </td>
                            @if(Auth::user()->is_admin)
                                <td style="text-align: right;">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="link-editar">Editar</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Eliminar esta categoria?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-eliminar">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
