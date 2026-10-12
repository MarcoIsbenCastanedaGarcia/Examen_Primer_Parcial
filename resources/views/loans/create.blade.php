@extends('layouts.app')

@section('title', 'Solicitar préstamo')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Préstamos
                </span>

                <h1>
                    Solicitar préstamo
                </h1>

                <p>
                    Selecciona uno o varios equipos e indica el periodo
                    en el que los necesitas.
                </p>

            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('loans.store') }}"
            >

                @csrf

                <div class="form-group">

                    <label>
                        Equipos solicitados
                    </label>

                    <div class="equipment-selector">

                        @forelse($equipment as $item)

                            <label class="equipment-option">

                                <input
                                    type="checkbox"
                                    name="equipment_ids[]"
                                    value="{{ $item->id }}"
                                    @checked(
                                        in_array(
                                            $item->id,
                                            old('equipment_ids', [])
                                        )
                                    )
                                >

                                <span class="equipment-option-content">

                                    <strong>
                                        {{ $item->name }}
                                    </strong>

                                    <span>
                                        {{ $item->inventory_code }}
                                        ·
                                        {{ $item->category->name }}
                                    </span>

                                    <span class="status status-{{ $item->availability_status }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->availability_status)) }}
                                    </span>

                                </span>

                            </label>

                        @empty

                            <p class="empty-state">
                                No existen equipos disponibles para mostrar.
                            </p>

                        @endforelse

                    </div>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label for="start_at">
                            Fecha y hora de inicio
                        </label>

                        <input
                            type="datetime-local"
                            id="start_at"
                            name="start_at"
                            value="{{ old('start_at') }}"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="end_at">
                            Fecha y hora de devolución
                        </label>

                        <input
                            type="datetime-local"
                            id="end_at"
                            name="end_at"
                            value="{{ old('end_at') }}"
                            required
                        >

                    </div>

                    <div class="form-group form-group-full">

                        <label for="purpose">
                            Motivo del préstamo
                        </label>

                        <textarea
                            id="purpose"
                            name="purpose"
                            rows="5"
                            required
                            placeholder="Describe para qué utilizarás el equipo"
                        >{{ old('purpose') }}</textarea>

                    </div>

                    <div class="form-group form-group-full">

                        <label for="notes">
                            Observaciones adicionales
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                        >{{ old('notes') }}</textarea>

                    </div>

                </div>

                <div class="form-actions">

                    <a
                        href="{{ route('inventory.index') }}"
                        class="button button-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="button button-primary"
                    >
                        Enviar solicitud
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection