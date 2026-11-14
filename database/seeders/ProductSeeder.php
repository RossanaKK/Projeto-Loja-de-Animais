<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Ração Seca Premium Salmão 3kg',
                'description' => 'Alimento completo rico em ómega 3 para pelo brilhante.',
                'price' => 24.90,
                'image' => 'img/racao.jpg',
                'category_id' => 1,
                'owner_id' => 1, // <--- Adiciona esta linha em todos os produtos
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arranhador Torre em Sisal',
                'description' => 'Torre arranhador resistente com brinquedos suspensos para gatos.',
                'price' => 39.50,
                'image' => 'img/arranhador.jpg',
                'category_id' => 2,
                'owner_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coleira Ajustável Refletora',
                'description' => 'Coleira confortável com faixa refletora para passeios noturnos seguros.',
                'price' => 11.99,
                'image' => 'img/coleira.jpg',
                'category_id' => 3,
                'owner_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champô Suave Aveia 500ml',
                'description' => 'Champô dermatológico com extrato de aveia para peles sensíveis.',
                'price' => 9.50,
                'image' => 'img/champu.jpg',
                'category_id' => 4,
                'owner_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
