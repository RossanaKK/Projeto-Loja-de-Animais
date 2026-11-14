@extends('layouts.main')

@section('content')
    <main class="container-loja" style="max-width: 550px;">
        <h1>Criar Categoria</h1>

        <div id="createCategoryBox" class="form-box">
            <form id="createCategoryForm" method="POST" action="{{ route('categories.store') }}">
                @csrf

                <label for="name">Nome da Categoria</label>
                <input id="name" name="name" type="text" placeholder="Nome da Categoria" value="{{ old('name') }}">
            </form>

            <div class="form-buttons">
                <a href="{{ route('categories.index') }}">
                    <div class="button button-voltar">Voltar</div>
                </a>
                <div class="button" onclick="submitForm('createCategoryForm')">
                    Gravar
                </div>
            </div>

            @if(count($errors) > 0)
                <div class="erros-box">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@endsection
