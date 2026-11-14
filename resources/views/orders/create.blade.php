@extends('layouts.main')

@section('content')
    <main class="container-loja" style="max-width: 650px;">
        <h1>Efetuar Encomenda</h1>

        <div id="createOrderBox" class="form-box">
            <form id="createOrderForm" method="POST" action="{{ route('orders.store') }}">
                @csrf

                <label for="product_id">Escolher Produto</label>
                <select id="product_id" name="product_id">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ number_format($product->price, 2, ',', '.') }} €)
                        </option>
                    @endforeach
                </select>

                <label for="quantity">Quantidade</label>
                <input id="quantity" name="quantity" type="number" value="{{ old('quantity', 1) }}" min="1">
            </form>

            <div class="form-buttons">
                <a href="{{ route('orders.index') }}">
                    <div class="button button-voltar">Voltar</div>
                </a>
                <div class="button" onclick="submitForm('createOrderForm')">
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
