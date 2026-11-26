<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin) {
            $orders = Order::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
        } else {
            $orders = Order::with('product')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->isAdmin) {
            return redirect()->back()->with('error', 'Os administradores não podem efetuar compras.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Produto inválido.',
            'product_id.exists' => 'O produto selecionado não existe.',
            'quantity.required' => 'Indica a quantidade pretendida.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade mínima é 1 unidade.',
        ]);

        $produto = Product::findOrFail($request->product_id);

        $order = new Order();
        $order->user_id = Auth::id();
        $order->product_id = $produto->id;
        $order->quantity = $request->quantity;
        $order->total_value = $produto->price * $request->quantity;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Encomenda registada com sucesso!');
    }

    public function show($id)
    {
        $order = Order::with(['product', 'user'])->findOrFail($id);

        if (! Auth::user()->isAdmin && $order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'Não tens permissão para ver esta encomenda.');
        }

        return view('orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (! Auth::user()->isAdmin && $order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'Não tens permissão para cancelar esta encomenda.');
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Encomenda removida com sucesso.');
    }
}
