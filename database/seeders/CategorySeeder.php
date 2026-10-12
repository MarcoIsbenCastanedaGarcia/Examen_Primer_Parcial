<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            [
                'name' => 'Laptops',
            ],
            [
                'description' =>
                    'Equipos de cómputo portátiles disponibles para préstamo.',

                'active' => true,
            ]
        );

        Category::updateOrCreate(
            [
                'name' => 'Proyectores',
            ],
            [
                'description' =>
                    'Equipos para proyección de contenido audiovisual.',

                'active' => true,
            ]
        );

        Category::updateOrCreate(
            [
                'name' => 'Accesorios',
            ],
            [
                'description' =>
                    'Cables, adaptadores y accesorios de apoyo.',

                'active' => true,
            ]
        );
    }
}