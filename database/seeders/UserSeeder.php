<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' =>
                    'solicitante@institucion.edu',
            ],
            [
                'name' =>
                    'Usuario Solicitante',

                'password' =>
                    Hash::make(
                        'Solicitante2026!'
                    ),

                'role' =>
                    'solicitante',
            ]
        );

        User::updateOrCreate(
            [
                'email' =>
                    'encargado@institucion.edu',
            ],
            [
                'name' =>
                    'Encargado de Equipos',

                'password' =>
                    Hash::make(
                        'Encargado2026!'
                    ),

                'role' =>
                    'encargado',
            ]
        );
    }
}