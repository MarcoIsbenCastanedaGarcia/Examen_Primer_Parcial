<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanService
{
    public function requestLoan(
        User $user,
        array $data
    ): Loan {
        return DB::transaction(
            function () use (
                $user,
                $data
            ): Loan {
                $equipmentIds =
                    array_values(
                        array_unique(
                            $data['equipment_ids']
                        )
                    );

                $equipment =
                    Equipment::whereIn(
                        'id',
                        $equipmentIds
                    )
                    ->lockForUpdate()
                    ->get();

                if (
                    $equipment->count()
                    !== count($equipmentIds)
                ) {
                    throw ValidationException::withMessages([
                        'equipment_ids' =>
                            'Uno o más equipos seleccionados no existen.',
                    ]);
                }

                foreach ($equipment as $item) {
                    if (
                        in_array(
                            $item->physical_state,
                            [
                                'danado',
                                'mantenimiento',
                                'baja',
                            ],
                            true
                        )
                    ) {
                        throw ValidationException::withMessages([
                            'equipment_ids' =>
                                "El equipo {$item->inventory_code} no está disponible debido a su estado físico.",
                        ]);
                    }

                    if ($item->hasActiveIncidents()) {
                        throw ValidationException::withMessages([
                            'equipment_ids' =>
                                "El equipo {$item->inventory_code} tiene una incidencia activa.",
                        ]);
                    }
                }

                $loan = Loan::create([
                    'user_id' =>
                        $user->id,

                    'start_at' =>
                        $data['start_at'],

                    'end_at' =>
                        $data['end_at'],

                    'purpose' =>
                        $data['purpose'],

                    'status' =>
                        'pendiente',

                    'notes' =>
                        $data['notes']
                        ?? null,
                ]);

                foreach ($equipmentIds as $equipmentId) {
                    $loan->items()->create([
                        'equipment_id' =>
                            $equipmentId,
                    ]);
                }

                return $loan->load(
                    'items.equipment'
                );
            }
        );
    }

    public function approve(
        Loan $loan,
        User $encargado
    ): Loan {
        return DB::transaction(
            function () use (
                $loan,
                $encargado
            ): Loan {
                $loan =
                    Loan::whereKey($loan->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                if ($loan->status !== 'pendiente') {
                    throw ValidationException::withMessages([
                        'loan' =>
                            'Solo se pueden aprobar solicitudes pendientes.',
                    ]);
                }

                $loan->load(
                    'items.equipment'
                );

                foreach ($loan->items as $item) {
                    $equipment =
                        Equipment::whereKey(
                            $item->equipment_id
                        )
                            ->lockForUpdate()
                            ->firstOrFail();

                    if (
                        in_array(
                            $equipment
                                ->physical_state,
                            [
                                'danado',
                                'mantenimiento',
                                'baja',
                            ],
                            true
                        )
                    ) {
                        throw ValidationException::withMessages([
                            'loan' =>
                                "El equipo {$equipment->inventory_code} no se encuentra en condiciones para ser prestado.",
                        ]);
                    }

                    if (
                        $equipment
                            ->hasActiveIncidents()
                    ) {
                        throw ValidationException::withMessages([
                            'loan' =>
                                "El equipo {$equipment->inventory_code} tiene una incidencia activa.",
                        ]);
                    }

                    $conflict =
                        Loan::query()
                            ->where(
                                'id',
                                '!=',
                                $loan->id
                            )
                            ->whereIn(
                                'status',
                                [
                                    'aprobado',
                                    'entregado',
                                ]
                            )
                            ->where(
                                'start_at',
                                '<',
                                $loan->end_at
                            )
                            ->where(
                                'end_at',
                                '>',
                                $loan->start_at
                            )
                            ->whereHas(
                                'items',
                                function (
                                    $query
                                ) use (
                                    $equipment
                                ): void {
                                    $query->where(
                                        'equipment_id',
                                        $equipment->id
                                    );
                                }
                            )
                            ->exists();

                    if ($conflict) {
                        throw ValidationException::withMessages([
                            'loan' =>
                                "El equipo {$equipment->inventory_code} ya está reservado para ese horario.",
                        ]);
                    }
                }

                $loan->update([
                    'status' =>
                        'aprobado',

                    'reviewed_by' =>
                        $encargado->id,

                    'reviewed_at' =>
                        now(),

                    'rejection_reason' =>
                        null,
                ]);

                return $loan->fresh([
                    'user',
                    'items.equipment',
                ]);
            }
        );
    }

    public function reject(
        Loan $loan,
        User $encargado,
        string $reason
    ): Loan {
        if ($loan->status !== 'pendiente') {
            throw ValidationException::withMessages([
                'loan' =>
                    'Solo se pueden rechazar solicitudes pendientes.',
            ]);
        }

        $loan->update([
            'status' =>
                'rechazado',

            'reviewed_by' =>
                $encargado->id,

            'reviewed_at' =>
                now(),

            'rejection_reason' =>
                $reason,
        ]);

        return $loan->fresh();
    }

    public function deliver(
        Loan $loan,
        User $encargado,
        ?string $notes = null
    ): Loan {
        return DB::transaction(
            function () use (
                $loan,
                $encargado,
                $notes
            ): Loan {
                $loan =
                    Loan::whereKey($loan->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                if ($loan->status !== 'aprobado') {
                    throw ValidationException::withMessages([
                        'loan' =>
                            'Solo se pueden entregar préstamos aprobados.',
                    ]);
                }

                $loan->load(
                    'items.equipment'
                );

                foreach ($loan->items as $item) {
                    $equipment =
                        Equipment::whereKey(
                            $item->equipment_id
                        )
                            ->lockForUpdate()
                            ->firstOrFail();

                    if (
                        $equipment
                            ->availability_status
                        === 'prestado'
                    ) {
                        throw ValidationException::withMessages([
                            'loan' =>
                                "El equipo {$equipment->inventory_code} ya está marcado como prestado.",
                        ]);
                    }

                    if (
                        $equipment
                            ->hasActiveIncidents()
                    ) {
                        throw ValidationException::withMessages([
                            'loan' =>
                                "El equipo {$equipment->inventory_code} tiene una incidencia activa.",
                        ]);
                    }

                    $equipment->update([
                        'availability_status' =>
                            'prestado',
                    ]);

                    $item->update([
                        'condition_on_delivery' =>
                            $equipment
                                ->physical_state,
                    ]);
                }

                $loan->update([
                    'status' =>
                        'entregado',

                    'delivered_by' =>
                        $encargado->id,

                    'delivered_at' =>
                        now(),

                    'notes' =>
                        $notes
                        ?? $loan->notes,
                ]);

                return $loan->fresh([
                    'user',
                    'items.equipment',
                ]);
            }
        );
    }

    public function returnLoan(
        Loan $loan,
        User $encargado,
        ?string $notes = null
    ): Loan {
        return DB::transaction(
            function () use (
                $loan,
                $encargado,
                $notes
            ): Loan {
                $loan =
                    Loan::whereKey($loan->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                if ($loan->status !== 'entregado') {
                    throw ValidationException::withMessages([
                        'loan' =>
                            'Solo se pueden devolver préstamos que fueron entregados.',
                    ]);
                }

                $loan->load(
                    'items.equipment'
                );

                foreach ($loan->items as $item) {
                    $equipment =
                        Equipment::whereKey(
                            $item->equipment_id
                        )
                            ->lockForUpdate()
                            ->firstOrFail();

                    $item->update([
                        'condition_on_return' =>
                            $equipment
                                ->physical_state,
                    ]);

                    $activeIncident =
                        $equipment
                            ->incidents()
                            ->whereNotIn(
                                'status',
                                ['cerrada']
                            )
                            ->exists();

                    $equipment->update([
                        'availability_status' =>
                            $activeIncident
                                ? 'no_disponible'
                                : 'disponible',
                    ]);
                }

                $loan->update([
                    'status' =>
                        'devuelto',

                    'returned_by' =>
                        $encargado->id,

                    'returned_at' =>
                        now(),

                    'notes' =>
                        $notes
                        ?? $loan->notes,
                ]);

                return $loan->fresh([
                    'user',
                    'items.equipment',
                ]);
            }
        );
    }
}