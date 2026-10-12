<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IncidentService
{
    public function create(
        User $user,
        array $data
    ): Incident {
        return DB::transaction(
            function () use (
                $user,
                $data
            ): Incident {
                $incident =
                    Incident::create([
                        'equipment_id' =>
                            $data[
                                'equipment_id'
                            ],

                        'reported_by' =>
                            $user->id,

                        'type' =>
                            $data['type'],

                        'description' =>
                            $data[
                                'description'
                            ],

                        'status' =>
                            'reportada',

                        'reported_at' =>
                            now(),
                    ]);

                $equipment =
                    Equipment::findOrFail(
                        $data['equipment_id']
                    );

                if (
                    $equipment
                        ->availability_status
                    !== 'prestado'
                ) {
                    $equipment->update([
                        'availability_status' =>
                            'no_disponible',
                    ]);
                }

                return $incident->load([
                    'equipment',
                    'reporter',
                ]);
            }
        );
    }

    public function update(
        Incident $incident,
        User $encargado,
        array $data
    ): Incident {
        return DB::transaction(
            function () use (
                $incident,
                $encargado,
                $data
            ): Incident {
                $incident->update([
                    'type' =>
                        $data['type'],

                    'description' =>
                        $data['description'],

                    'status' =>
                        $data['status'],

                    'follow_up' =>
                        $data['follow_up']
                        ?? null,

                    'attended_by' =>
                        $encargado->id,

                    'resolved_at' =>
                        $data['status']
                        === 'cerrada'
                            ? now()
                            : null,
                ]);

                if (
                    $data['status']
                    === 'cerrada'
                ) {
                    $this
                        ->refreshEquipmentAvailability(
                            $incident->equipment
                        );
                } else {
                    $incident
                        ->equipment
                        ->update([
                            'availability_status' =>
                                'no_disponible',
                        ]);
                }

                return $incident->fresh([
                    'equipment',
                    'reporter',
                    'attendant',
                ]);
            }
        );
    }

    public function delete(
        Incident $incident
    ): void {
        DB::transaction(
            function () use (
                $incident
            ): void {
                $equipment =
                    $incident->equipment;

                $incident->delete();

                $this
                    ->refreshEquipmentAvailability(
                        $equipment
                    );
            }
        );
    }

    private function refreshEquipmentAvailability(
        Equipment $equipment
    ): void {
        $activeIncidents =
            $equipment
                ->incidents()
                ->whereNotIn(
                    'status',
                    ['cerrada']
                )
                ->exists();

        $activeLoan =
            $equipment
                ->loanItems()
                ->whereHas(
                    'loan',
                    function (
                        $query
                    ): void {
                        $query->where(
                            'status',
                            'entregado'
                        );
                    }
                )
                ->exists();

        if ($activeLoan) {
            $equipment->update([
                'availability_status' =>
                    'prestado',
            ]);

            return;
        }

        if ($activeIncidents) {
            $equipment->update([
                'availability_status' =>
                    'no_disponible',
            ]);

            return;
        }

        if (
            $equipment->physical_state
            === 'baja'
        ) {
            $equipment->update([
                'availability_status' =>
                    'no_disponible',
            ]);

            return;
        }

        $equipment->update([
            'availability_status' =>
                'disponible',
        ]);
    }
}