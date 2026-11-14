<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@loja.pt')->first();
        $alimentacao = Category::where('name', 'Alimentação')->first();
        $brinquedos = Category::where('name', 'Brinquedos')->first();
        $acessorios = Category::where('name', 'Acessórios')->first();
        $higiene = Category::where('name', 'Higiene')->first();

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
    }
}
