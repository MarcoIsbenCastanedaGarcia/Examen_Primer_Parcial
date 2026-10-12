<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function __construct(
        private readonly EquipmentService $service
    ) {
    }

    public function index(): RedirectResponse
    {
        return redirect()
            ->route(
                'inventory.index'
            );
    }

    public function create(): View
    {
        $categories =
            Category::where(
                'active',
                true
            )
                ->orderBy('name')
                ->get();

        return view(
            'equipment.create',
            compact('categories')
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $data =
            $request->validate([
                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],

                'inventory_code' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:equipment,inventory_code',
                ],

                'name' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'brand' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'model' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'serial_number' => [
                    'nullable',
                    'string',
                    'max:120',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'availability_status' => [
                    'required',
                    Rule::in([
                        'disponible',
                        'reservado',
                        'prestado',
                        'no_disponible',
                    ]),
                ],

                'physical_state' => [
                    'required',
                    Rule::in([
                        'bueno',
                        'regular',
                        'danado',
                        'mantenimiento',
                        'baja',
                    ]),
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

                'notes' => [
                    'nullable',
                    'string',
                ],
            ]);

        $this->service->create(
            $data
        );

        return redirect()
            ->route(
                'inventory.index'
            )
            ->with(
                'success',
                'Equipo registrado correctamente.'
            );
    }

    public function edit(
        Equipment $equipment
    ): View {
        $categories =
            Category::orderBy(
                'name'
            )->get();

        return view(
            'equipment.edit',
            compact(
                'equipment',
                'categories'
            )
        );
    }

    public function update(
        Request $request,
        Equipment $equipment
    ): RedirectResponse {
        $data =
            $request->validate([
                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],

                'inventory_code' => [
                    'required',
                    'string',
                    'max:50',

                    Rule::unique(
                        'equipment',
                        'inventory_code'
                    )->ignore(
                        $equipment->id
                    ),
                ],

                'name' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'brand' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'model' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'serial_number' => [
                    'nullable',
                    'string',
                    'max:120',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'availability_status' => [
                    'required',
                    Rule::in([
                        'disponible',
                        'reservado',
                        'prestado',
                        'no_disponible',
                    ]),
                ],

                'physical_state' => [
                    'required',
                    Rule::in([
                        'bueno',
                        'regular',
                        'danado',
                        'mantenimiento',
                        'baja',
                    ]),
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

                'notes' => [
                    'nullable',
                    'string',
                ],
            ]);

        $this->service->update(
            $equipment,
            $data
        );

        return redirect()
            ->route(
                'inventory.index'
            )
            ->with(
                'success',
                'Equipo actualizado correctamente.'
            );
    }

    public function destroy(
        Equipment $equipment
    ): RedirectResponse {
        $this->service->delete(
            $equipment
        );

        return redirect()
            ->route(
                'inventory.index'
            )
            ->with(
                'success',
                'Equipo eliminado correctamente.'
            );
    }

    public function importForm(): View
    {
        return view(
            'equipment.import'
        );
    }

    public function importStore(
        Request $request
    ): RedirectResponse {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:txt,json',
                'max:5120',
            ],
        ]);

        $result =
            $this->service
                ->importTxtJson(
                    $request->file(
                        'archivo'
                    )
                );

        return redirect()
            ->route(
                'inventory.index'
            )
            ->with(
                'success',
                "Carga masiva terminada. Nuevos: {$result['created']}. Actualizados: {$result['updated']}. Total: {$result['total']}."
            );
    }

    public function exportTxt()
    {
        $content =
            $this->service
                ->exportTxtJson();

        $filename =
            'inventario_'
            .now()->format(
                'Ymd_His'
            )
            .'.txt';

        return response(
            $content,
            200,
            [
                'Content-Type' =>
                    'text/plain; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="'
                    .$filename
                    .'"',
            ]
        );
    }
}