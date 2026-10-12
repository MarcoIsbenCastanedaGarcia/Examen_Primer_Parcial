@extends('layouts.app')

@section('title', 'Atender incidencia')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Administración de incidencias
                </span>

                <h1>
                    Atender incidencia
                </h1>

                <p>
                    {{ $incident->equipment->inventory_code }}
                    ·
                    {{ $incident->equipment->name }}
                </p>

            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('incidents.update', $incident) }}"
            >

                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">

                        <label for="type">
                            Tipo
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                        >

                            @php
                                $type = old('type', $incident->type);
                            @endphp

                            <option
                                value="dano"
                                @selected($type === 'dano')
                            >
                                Daño
                            </option>

                            <option
                                value="falla"
                                @selected($type === 'falla')
                            >
                                Falla
                            </option>

                            <option
                                value="perdida"
                                @selected($type === 'perdida')
                            >
                                Pérdida
                            </option>

                            <option
                                value="otro"
                                @selected($type === 'otro')
                            >
                                Otro
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="status">
                            Estado
                        </label>

                        @php
                            $status = old('status', $incident->status);
                        @endphp

                        <select
                            id="status"
                            name="status"
                            required
                        >

                            <option
                                value="reportada"
                                @selected($status === 'reportada')
                            >
                                Reportada
                            </option>

                            <option
                                value="en_revision"
                                @selected($status === 'en_revision')
                            >
                                En revisión
                            </option>

                            <option
                                value="atendida"
                                @selected($status === 'atendida')
                            >
                                Atendida
                            </option>

                            <option
                                value="cerrada"
                                @selected($status === 'cerrada')
                            >
                                Cerrada
                            </option>

                        </select>

                    </div>

                    <div class="form-group form-group-full">

                        <label for="description">
                            Descripción
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            required
                        >{{ old('description', $incident->description) }}</textarea>

                    </div>

                    <div class="form-group form-group-full">

                        <label for="follow_up">
                            Seguimiento
                        </label>

                        <textarea
                            id="follow_up"
                            name="follow_up"
                            rows="6"
                            placeholder="Describe las acciones realizadas para atender la incidencia"
                        >{{ old('follow_up', $incident->follow_up) }}</textarea>

                    </div>

                </div>

                <div class="form-actions">

                    <a
                        href="{{ route('incidents.index') }}"
                        class="button button-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="button button-primary"
                    >
                        Guardar seguimiento
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection