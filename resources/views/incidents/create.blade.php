@extends('layouts.app')

@section('title', 'Nueva incidencia')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Incidencias
                </span>

                <h1>
                    Crear nueva incidencia
                </h1>

                <p>
                    Reporta cualquier daño, falla o problema relacionado
                    con un equipo.
                </p>

            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('incidents.store') }}"
            >

                @csrf

                <div class="form-grid">

                    <div class="form-group form-group-full">

                        <label for="equipment_id">
                            Equipo
                        </label>

                        <select
                            id="equipment_id"
                            name="equipment_id"
                            required
                        >

                            <option value="">
                                Selecciona un equipo
                            </option>

                            @foreach($equipment as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('equipment_id') == $item->id)
                                >
                                    {{ $item->inventory_code }}
                                    -
                                    {{ $item->name }}
                                    -
                                    {{ $item->category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="type">
                            Categoría de incidencia
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                        >

                            <option value="">
                                Selecciona
                            </option>

                            <option
                                value="dano"
                                @selected(old('type') === 'dano')
                            >
                                Daño
                            </option>

                            <option
                                value="falla"
                                @selected(old('type') === 'falla')
                            >
                                Falla
                            </option>

                            <option
                                value="perdida"
                                @selected(old('type') === 'perdida')
                            >
                                Pérdida
                            </option>

                            <option
                                value="otro"
                                @selected(old('type') === 'otro')
                            >
                                Otro
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>
                            Quién crea la incidencia
                        </label>

                        <input
                            type="text"
                            value="{{ auth()->user()->name }}"
                            disabled
                        >

                    </div>

                    <div class="form-group form-group-full">

                        <label for="description">
                            Descripción
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            required
                            placeholder="Describe claramente el problema detectado"
                        >{{ old('description') }}</textarea>

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
                        Registrar incidencia
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection