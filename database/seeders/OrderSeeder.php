<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'cliente@loja.pt')->first();
        $racao = Product::where('name', 'Ração Seca Premium Salmão 3kg')->first();

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $racao->id;
        $order->quantity = 2;
        $order->total_value = $racao->price * 2;
        $order->save();
    }
}
