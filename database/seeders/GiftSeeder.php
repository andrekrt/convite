<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gift::create([
            'title'=>'Cota para Lua de Mel',
            'description'=>'Contribua para nossa primeira viagem como casados!',
            'price'=>250.00,
            'image'=>'lua-de-mel.jpg'
        ]);

        Gift::create([
            'title'=>'Casa',
            'description'=>'Nos ajude a comprar nosso primeiro imóvel!',
            'price'=>250000.00,
            'image'=>'casa.jpg'
        ]);

        Gift::create([
            'title'=>'Carro',
            'description'=>'Nos ajude a comprar o nosso primeiro carro!',
            'price'=>80000.00,
            'image'=>'carro.jpg'
        ]);
    }
}
