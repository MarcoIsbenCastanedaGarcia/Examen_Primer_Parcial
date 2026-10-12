@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Inventario
                </span>

                <h1>
                    Categorías
                </h1>

                <p>
                    Administra los tipos de equipos registrados.
                </p>

            </div>

            <a
                href="{{ route('categories.create') }}"
                class="button button-primary"
            >
                Nueva categoría
            </a>

        </div>

        <div class="table-card">

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Nombre
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Equipos
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    <strong>
                                        {{ $category->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $category->description ?? 'Sin descripción' }}
                                </td>

                                <td>
                                    {{ $category->equipment_count }}
                                </td>

                                <td>

                                    <span class="status {{ $category->active ? 'status-disponible' : 'status-no_disponible' }}">
                                        {{ $category->active ? 'Activa' : 'Inactiva' }}
                                    </span>

                                </td>

                                <td>

                                    <div class="table-actions">

                                        <a
                                            href="{{ route('categories.edit', $category) }}"
                                            class="icon-button"
                                            title="Editar"
                                        >

                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="m4 16.5-.5 4 4-.5L18.7 8.8l-3.5-3.5L4 16.5ZM20.7 6.8a1 1 0 0 0 0-1.4l-2.1-2.1a1 1 0 0 0-1.4 0l-1 1 3.5 3.5 1-1Z"
                                                />
                                            </svg>

                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('categories.destroy', $category) }}"
                                            data-confirm="¿Seguro que quieres eliminar esta categoría?"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="icon-button icon-button-danger"
                                            >

                                                <svg viewBox="0 0 24 24">
                                                    <path
                                                        d="M7 4V2h10v2h5v2h-2v16H4V6H2V4h5Zm2 0h6V3H9v1Zm-3 2v14h12V6H6Zm3 3h2v8H9V9Zm4 0h2v8h-2V9Z"
                                                    />
                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="5"
                                    class="empty-state"
                                >
                                    No existen categorías registradas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $categories->links() }}
            </div>

        </div>

    </div>

</section>

@endsection