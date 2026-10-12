<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $laptops =
            Category::where(
                'name',
                'Laptops'
            )->firstOrFail();

        $projectors =
            Category::where(
                'name',
                'Proyectores'
            )->firstOrFail();

        $accessories =
            Category::where(
                'name',
                'Accesorios'
            )->firstOrFail();

        Equipment::updateOrCreate(
            [
                'inventory_code' =>
                    'LAP-001',
            ],
            [
                'category_id' =>
                    $laptops->id,

                'name' =>
                    'Laptop Dell Latitude',

                'brand' =>
                    'Dell',

                'model' =>
                    'Latitude 5420',

                'serial_number' =>
                    'DL5420-001',

                'description' =>
                    'Laptop institucional para actividades académicas.',

                'availability_status' =>
                    'disponible',

                'physical_state' =>
                    'bueno',

                'location' =>
                    'Almacén principal',

                'notes' =>
                    null,
            ]
        );

        Equipment::updateOrCreate(
            [
                'inventory_code' =>
                    'LAP-002',
            ],
            [
                'category_id' =>
                    $laptops->id,

                'name' =>
                    'Laptop HP ProBook',

                'brand' =>
                    'HP',

                'model' =>
                    'ProBook 440',

                'serial_number' =>
                    'HP440-002',

                'description' =>
                    'Equipo portátil para préstamo escolar.',

                'availability_status' =>
                    'disponible',

                'physical_state' =>
                    'regular',

                'location' =>
                    'Almacén principal',

                'notes' =>
                    'Presenta desgaste exterior leve.',
            ]
        );

        Equipment::updateOrCreate(
            [
                'inventory_code' =>
                    'PRO-001',
            ],
            [
                'category_id' =>
                    $projectors->id,

                'name' =>
                    'Proyector Epson',

                'brand' =>
                    'Epson',

                'model' =>
                    'PowerLite E20',

                'serial_number' =>
                    'EP-E20-001',

                'description' =>
                    'Proyector para aulas y salas de exposición.',

                'availability_status' =>
                    'disponible',

                'physical_state' =>
                    'bueno',

                'location' =>
                    'Almacén audiovisual',

                'notes' =>
                    null,
            ]
        );

        Equipment::updateOrCreate(
            [
                'inventory_code' =>
                    'ACC-001',
            ],
            [
                'category_id' =>
                    $accessories->id,

                'name' =>
                    'Adaptador HDMI a USB-C',

                'brand' =>
                    'Genérico',

                'model' =>
                    null,

                'serial_number' =>
                    null,

                'description' =>
                    'Adaptador para conexión de equipos a proyectores.',

                'availability_status' =>
                    'disponible',

                'physical_state' =>
                    'bueno',

                'location' =>
                    'Almacén audiovisual',

                'notes' =>
                    null,
            ]
        );
    }
}