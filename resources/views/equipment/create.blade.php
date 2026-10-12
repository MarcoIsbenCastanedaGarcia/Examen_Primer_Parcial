@extends('layouts.app')

@section('title', 'Registrar equipo')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>
                <span class="eyebrow">
                    Inventario
                </span>

                <h1>
                    Registrar nuevo equipo
                </h1>
            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('equipment.store') }}"
            >

                @csrf

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
                        Guardar equipo
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection