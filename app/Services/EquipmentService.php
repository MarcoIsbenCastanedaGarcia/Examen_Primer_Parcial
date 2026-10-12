<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EquipmentService
{
    public function create(array $data): Equipment
    {
        return Equipment::create($data);
    }

    public function update(
        Equipment $equipment,
        array $data
    ): Equipment {
        $equipment->update($data);

        return $equipment->fresh();
    }

    public function delete(Equipment $equipment): void
    {
        if ($equipment->loanItems()->exists()) {
            throw ValidationException::withMessages([
                'equipment' =>
                    'No se puede eliminar este equipo porque tiene historial de préstamos.',
            ]);
        }

        if ($equipment->incidents()->exists()) {
            throw ValidationException::withMessages([
                'equipment' =>
                    'No se puede eliminar este equipo porque tiene incidencias registradas.',
            ]);
        }

        $equipment->delete();
    }

    public function importTxtJson(
        UploadedFile $file
    ): array {
        $content = file_get_contents(
            $file->getRealPath()
        );

        $decoded = json_decode(
            $content,
            true
        );

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ValidationException::withMessages([
                'archivo' =>
                    'El archivo no contiene JSON válido.',
            ]);
        }

        $records =
            isset($decoded['equipos'])
            && is_array($decoded['equipos'])
                ? $decoded['equipos']
                : $decoded;

        if (
            ! is_array($records)
            || ! array_is_list($records)
        ) {
            throw ValidationException::withMessages([
                'archivo' =>
                    'El TXT debe contener un arreglo JSON de equipos.',
            ]);
        }

        $created = 0;
        $updated = 0;

        DB::transaction(
            function () use (
                $records,
                &$created,
                &$updated
            ): void {
                foreach ($records as $index => $record) {
                    if (! is_array($record)) {
                        throw ValidationException::withMessages([
                            'archivo' =>
                                'El registro '.($index + 1).' no tiene un formato válido.',
                        ]);
                    }

                    $validator = Validator::make(
                        $record,
                        [
                            'codigo_inventario' => [
                                'required',
                                'string',
                                'max:50',
                            ],

                            'nombre' => [
                                'required',
                                'string',
                                'max:150',
                            ],

                            'categoria' => [
                                'required',
                                'string',
                                'max:100',
                            ],

                            'marca' => [
                                'nullable',
                                'string',
                                'max:100',
                            ],

                            'modelo' => [
                                'nullable',
                                'string',
                                'max:100',
                            ],

                            'numero_serie' => [
                                'nullable',
                                'string',
                                'max:120',
                            ],

                            'descripcion' => [
                                'nullable',
                                'string',
                            ],

                            'disponibilidad' => [
                                'nullable',
                                Rule::in([
                                    'disponible',
                                    'reservado',
                                    'prestado',
                                    'no_disponible',
                                ]),
                            ],

                            'estado' => [
                                'nullable',
                                Rule::in([
                                    'bueno',
                                    'regular',
                                    'danado',
                                    'mantenimiento',
                                    'baja',
                                ]),
                            ],

                            'ubicacion' => [
                                'nullable',
                                'string',
                                'max:150',
                            ],

                            'notas' => [
                                'nullable',
                                'string',
                            ],
                        ]
                    );

                    if ($validator->fails()) {
                        throw ValidationException::withMessages([
                            'archivo' =>
                                'Error en el registro '
                                .($index + 1)
                                .': '
                                .$validator
                                    ->errors()
                                    ->first(),
                        ]);
                    }

                    $data =
                        $validator->validated();

                    $category =
                        Category::firstOrCreate(
                            [
                                'name' =>
                                    trim(
                                        $data['categoria']
                                    ),
                            ],
                            [
                                'active' => true,
                            ]
                        );

                    $exists =
                        Equipment::where(
                            'inventory_code',
                            $data[
                                'codigo_inventario'
                            ]
                        )->exists();

                    Equipment::updateOrCreate(
                        [
                            'inventory_code' =>
                                $data[
                                    'codigo_inventario'
                                ],
                        ],
                        [
                            'category_id' =>
                                $category->id,

                            'name' =>
                                $data['nombre'],

                            'brand' =>
                                $data['marca']
                                ?? null,

                            'model' =>
                                $data['modelo']
                                ?? null,

                            'serial_number' =>
                                $data[
                                    'numero_serie'
                                ]
                                ?? null,

                            'description' =>
                                $data[
                                    'descripcion'
                                ]
                                ?? null,

                            'availability_status' =>
                                $data[
                                    'disponibilidad'
                                ]
                                ?? 'disponible',

                            'physical_state' =>
                                $data['estado']
                                ?? 'bueno',

                            'location' =>
                                $data[
                                    'ubicacion'
                                ]
                                ?? null,

                            'notes' =>
                                $data['notas']
                                ?? null,
                        ]
                    );

                    if ($exists) {
                        $updated++;
                    } else {
                        $created++;
                    }
                }
            }
        );

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => count($records),
        ];
    }

    public function exportTxtJson(): string
    {
        $equipment =
            Equipment::with('category')
                ->orderBy('inventory_code')
                ->get()
                ->map(
                    function (
                        Equipment $equipment
                    ): array {
                        return [
                            'codigo_inventario' =>
                                $equipment
                                    ->inventory_code,

                            'nombre' =>
                                $equipment->name,

                            'categoria' =>
                                $equipment
                                    ->category
                                    ?->name,

                            'marca' =>
                                $equipment->brand,

                            'modelo' =>
                                $equipment->model,

                            'numero_serie' =>
                                $equipment
                                    ->serial_number,

                            'descripcion' =>
                                $equipment
                                    ->description,

                            'disponibilidad' =>
                                $equipment
                                    ->availability_status,

                            'estado' =>
                                $equipment
                                    ->physical_state,

                            'ubicacion' =>
                                $equipment
                                    ->location,

                            'notas' =>
                                $equipment->notes,
                        ];
                    }
                )
                ->values()
                ->all();

        return json_encode(
            $equipment,
            JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );
    }
}