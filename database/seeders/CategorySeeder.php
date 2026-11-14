<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
