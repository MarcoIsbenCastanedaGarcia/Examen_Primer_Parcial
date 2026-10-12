<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Incident;
use App\Services\IncidentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function __construct(
        private readonly IncidentService $service
    ) {
    }

    public function index(
        Request $request
    ): View {
        $query =
            Incident::with([
                'equipment.category',
                'reporter',
                'attendant',
            ]);

        if (
            Auth::user()
                ->isSolicitante()
        ) {
            $query->where(
                'reported_by',
                Auth::id()
            );
        }

        if ($request->filled('search')) {
            $search =
                trim(
                    $request->string(
                        'search'
                    )->toString()
                );

            $query->where(
                function (
                    $query
                ) use (
                    $search
                ): void {
                    $query
                        ->where(
                            'description',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'type',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'status',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'equipment',
                            function (
                                $query
                            ) use (
                                $search
                            ): void {
                                $query
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'inventory_code',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }

        $incidents =
            $query
                ->orderByDesc(
                    'reported_at'
                )
                ->paginate(15)
                ->withQueryString();

        return view(
            'incidents.index',
            compact('incidents')
        );
    }

    public function create(): View
    {
        $equipment =
            Equipment::with('category')
                ->orderBy('name')
                ->get();

        return view(
            'incidents.create',
            compact('equipment')
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $data =
            $request->validate([
                'equipment_id' => [
                    'required',
                    'integer',
                    'exists:equipment,id',
                ],

                'type' => [
                    'required',
                    Rule::in([
                        'dano',
                        'falla',
                        'perdida',
                        'otro',
                    ]),
                ],

                'description' => [
                    'required',
                    'string',
                    'min:5',
                    'max:2000',
                ],
            ]);

        $this->service->create(
            Auth::user(),
            $data
        );

        return redirect()
            ->route(
                'incidents.index'
            )
            ->with(
                'success',
                'Incidencia registrada correctamente.'
            );
    }

    public function edit(
        Incident $incident
    ): View {
        return view(
            'incidents.edit',
            compact('incident')
        );
    }

    public function update(
        Request $request,
        Incident $incident
    ): RedirectResponse {
        $data =
            $request->validate([
                'type' => [
                    'required',
                    Rule::in([
                        'dano',
                        'falla',
                        'perdida',
                        'otro',
                    ]),
                ],

                'description' => [
                    'required',
                    'string',
                    'min:5',
                    'max:2000',
                ],

                'status' => [
                    'required',
                    Rule::in([
                        'reportada',
                        'en_revision',
                        'atendida',
                        'cerrada',
                    ]),
                ],

                'follow_up' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],
            ]);

        $this->service->update(
            $incident,
            Auth::user(),
            $data
        );

        return redirect()
            ->route(
                'incidents.index'
            )
            ->with(
                'success',
                'Incidencia actualizada correctamente.'
            );
    }

    public function destroy(
        Incident $incident
    ): RedirectResponse {
        $this->service->delete(
            $incident
        );

        return redirect()
            ->route(
                'incidents.index'
            )
            ->with(
                'success',
                'Incidencia eliminada correctamente.'
            );
    }
}