@extends('layouts.main')

@section('content')
    <main class="container-loja">
        <h1>{{ Auth::user()->is_admin ? 'Todas as Encomendas' : 'As Minhas Encomendas' }}</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($orders->isEmpty())
            <p>Ainda não existem encomendas registadas.</p>
        @else
            <table class="tabela-loja">
                <thead>
                    <tr>
                        <th>ID</th>
                        @if(Auth::user()->is_admin)
                            <th>Cliente</th>
                        @endif
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            @if(Auth::user()->is_admin)
                                <td>{{ $order->user->name }}</td>
                            @endif
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ number_format($order->total_value, 2, ',', '.') }} €</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>
@endsection
