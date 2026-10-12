@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>
                <span class="eyebrow">
                    Categorías
                </span>

                <h1>
                    Editar categoría
                </h1>
            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('categories.update', $category) }}"
            >

                @csrf
                @method('PUT')

                @include('categories._form')

                <div class="form-actions">

                    <a
                        href="{{ route('categories.index') }}"
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