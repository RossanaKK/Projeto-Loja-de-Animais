@extends('layouts.main')

@section('content')
<main class="container-loja" style="padding: 20px;">
    <h1>Encomendas</h1>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p style="padding: 20px; background: #1e293b; color: #e2e8f0; border-radius: 8px;">Ainda não existem encomendas registadas.</p>
    @else
        <table class="tabela-loja" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #112222; color: white; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    @if(Auth::user()->is_admin)
                        <th style="padding: 10px;">Cliente</th>
                    @endif
                    <th style="padding: 10px;">Produto</th>
                    <th style="padding: 10px;">Quantidade</th>
                    <th style="padding: 10px;">Valor Total</th>
                    <th style="padding: 10px;">Data</th>
                    <th style="padding: 10px; text-align: right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr style="border-bottom: 1px solid #334155;">
                    <td style="padding: 10px;">#{{ $order->id }}</td>
                    @if(Auth::user()->is_admin)
                        <td style="padding: 10px;">{{ $order->user?->name ?? 'Cliente removido' }}</td>
                    @endif
                    <td style="padding: 10px;">{{ $order->product?->name ?? 'Produto removido' }}</td>
                    <td style="padding: 10px;">{{ $order->quantity }}</td>
                    <td style="padding: 10px;">{{ number_format($order->total_value, 2, ',', '.') }} €</td>
                    <td style="padding: 10px;">{{ $order->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td style="padding: 10px; text-align: right;">
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tens a certeza que queres cancelar/remover esta encomenda?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</main>
@endsection
