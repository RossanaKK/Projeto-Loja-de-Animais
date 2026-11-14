@extends('layouts.main')

@section('content')
    <main class="container-loja" style="max-width: 650px;">
        @isset($pet)
            <h1>Editar {{ $pet->name }}</h1>
        @else
            <h1>Registar Animal</h1>
        @endisset

        <div id="createPetBox" class="form-box">
            <form id="createPetForm" method="POST"
                @isset($pet) action="{{ route('pets.update', $pet->id) }}" @else action="{{ route('pets.store') }}" @endisset
            >
                @csrf
                @isset($pet)
                    @method('PUT')
                @endisset

                <label for="name">Nome do Animal</label>
                <input id="name" name="name" type="text" placeholder="Nome"
                    value="{{ old('name') == null && isset($pet) ? $pet->name : old('name') }}">

                <label for="species">Espécie (ex: Cão, Gato)</label>
                <input id="species" name="species" type="text" placeholder="Espécie"
                    value="{{ old('species') == null && isset($pet) ? $pet->species : old('species') }}">

                <label for="breed">Raça (opcional)</label>
                <input id="breed" name="breed" type="text" placeholder="Raça"
                    value="{{ old('breed') == null && isset($pet) ? $pet->breed : old('breed') }}">
            </form>

            <div class="form-buttons">
                <a href="{{ route('pets.index') }}">
                    <div class="button button-voltar">Voltar</div>
                </a>
                <div class="button" onclick="submitForm('createPetForm')">
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
