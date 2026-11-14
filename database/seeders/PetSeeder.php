<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'cliente@loja.pt')->first();

        $pet = new Pet();
        $pet->user_id = $user->id;
        $pet->name = 'Karion';
        $pet->species = 'Gato';
        $pet->breed = 'Europeu Comum';
        $pet->save();
    }
}
