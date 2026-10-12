@extends('layouts.app')

@section('title', 'Editar equipo')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Inventario
                </span>

                <h1>
                    Editar equipo
                </h1>

                <p>
                    {{ $equipment->inventory_code }}
                    ·
                    {{ $equipment->name }}
                </p>

            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('equipment.update', $equipment) }}"
            >

                @csrf
                @method('PUT')

                @include('equipment._form')

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
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection