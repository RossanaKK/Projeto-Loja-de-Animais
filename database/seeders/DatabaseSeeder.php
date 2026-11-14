<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Administrador';
        $admin->email = 'admin@loja.pt';
        $admin->password = Hash::make('password123');
        $admin->is_admin = true;
        $admin->save();

        $user = new User();
        $user->name = 'Cliente Teste';
        $user->email = 'cliente@loja.pt';
        $user->password = Hash::make('password123');
        $user->is_admin = false;
        $user->save();

        $alimentacao = new Category();
        $alimentacao->name = 'Alimentação';
        $alimentacao->save();

        $brinquedos = new Category();
        $brinquedos->name = 'Brinquedos';
        $brinquedos->save();

        $acessorios = new Category();
        $acessorios->name = 'Acessórios';
        $acessorios->save();

        $higiene = new Category();
        $higiene->name = 'Higiene';
        $higiene->save();

        $racao = new Product();
        $racao->name = 'Ração Seca Premium Salmão 3kg';
        $racao->description = 'Alimento completo rico em Ómega 3 para pelo brilhante.';
        $racao->price = 24.90;
        $racao->image = 'img/racao.jpg';
        $racao->category_id = $alimentacao->id;
        $racao->owner_id = $admin->id;
        $racao->save();

        $arranhador = new Product();
        $arranhador->name = 'Arranhador Torre em Sisal';
        $arranhador->description = 'Arranhador vertical com plataforma superior para descanso.';
        $arranhador->price = 39.50;
        $arranhador->image = 'img/arranhador.jpg';
        $arranhador->category_id = $brinquedos->id;
        $arranhador->owner_id = $admin->id;
        $arranhador->save();

        $coleira = new Product();
        $coleira->name = 'Coleira Ajustável Refletora';
        $coleira->description = 'Coleira resistente com fecho de segurança para passeios noturnos.';
        $coleira->price = 11.99;
        $coleira->image = 'img/coleira.jpg';
        $coleira->category_id = $acessorios->id;
        $coleira->owner_id = $admin->id;
        $coleira->save();

        $champo = new Product();
        $champo->name = 'Champô Suave Aveia 500ml';
        $champo->description = 'Fórmula hipoalergénica para pele sensível.';
        $champo->price = 9.50;
        $champo->image = 'img/champu.jpg';
        $champo->category_id = $higiene->id;
        $champo->owner_id = $admin->id;
        $champo->save();

        $pet = new Pet();
        $pet->user_id = $user->id;
        $pet->name = 'Karion';
        $pet->species = 'Gato';
        $pet->breed = 'Europeu Comum';
        $pet->save();

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $racao->id;
        $order->quantity = 2;
        $order->total_value = $racao->price * 2;
        $order->save();
    }
}
