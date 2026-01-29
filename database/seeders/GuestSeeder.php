<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guest::create([
            'name'=>"João e Maria",
            'phone'=>"9999999",
            'invite_code'=>'teste123',
            'max_guests'=>2,
            'is_confirmed'=>false
        ]);

        Guest::create([
            'name'=>"Pedro e Ana",
            'phone'=>"8888888",
            'invite_code'=>'teste456',
            'max_guests'=>3,
            'is_confirmed'=>false
        ]);

        Guest::create([
            'name'=>"Carlos e Juliana",
            'phone'=>"7777777",
            'invite_code'=>'teste789',
            'max_guests'=>4,
            'is_confirmed'=>false
        ]);
    }
}
