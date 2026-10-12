@extends('layouts.app')

@section('title', 'Incidencias')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Seguimiento
                </span>

                <h1>
                    Incidencias
                </h1>

                <p>
                    Registro de daños, fallas y situaciones relacionadas
                    con los equipos.
                </p>

            </div>

            <a
                href="{{ route('incidents.create') }}"
                class="button button-primary"
            >
                Registrar incidencia
            </a>

        </div>

        <div class="panel">

            <form
                method="GET"
                action="{{ route('incidents.index') }}"
                class="search-inline"
            >

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar equipo, tipo, estado o descripción"
                >

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Buscar
                </button>

                <a
                    href="{{ route('incidents.index') }}"
                    class="button button-ghost"
                >
                    Limpiar
                </a>

            </form>

        </div>

        <div class="table-card">

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Equipo
                            </th>

                            <th>
                                Tipo
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Reportado por
                            </th>

                            <th>
                                Descripción
                            </th>

                            <th>
                                Estado
                            </th>

                            @if(auth()->user()->isEncargado())
                                <th>
                                    Acciones
                                </th>
                            @endif

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($incidents as $incident)

                            <tr>

                                <td>

                                    <strong>
                                        {{ $incident->equipment->name }}
                                    </strong>

                                    <span class="table-secondary">
                                        {{ $incident->equipment->inventory_code }}
                                    </span>

                                </td>

                                <td>
                                    {{ ucfirst($incident->type) }}
                                </td>

                                <td>
                                    {{ $incident->reported_at->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    {{ $incident->reporter->name }}
                                </td>

                                <td>
                                    {{ $incident->description }}
                                </td>

                                <td>

                                    <span class="status status-{{ $incident->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                    </span>

                                </td>

                                @if(auth()->user()->isEncargado())

                                    <td>

                                        <div class="table-actions">

                                            <a
                                                href="{{ route('incidents.edit', $incident) }}"
                                                class="icon-button"
                                            >

                                                <svg viewBox="0 0 24 24">
                                                    <path
                                                        d="m4 16.5-.5 4 4-.5L18.7 8.8l-3.5-3.5L4 16.5ZM20.7 6.8a1 1 0 0 0 0-1.4l-2.1-2.1a1 1 0 0 0-1.4 0l-1 1 3.5 3.5 1-1Z"
                                                    />
                                                </svg>

                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('incidents.destroy', $incident) }}"
                                                data-confirm="¿Seguro que quieres eliminar esta incidencia?"
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

                                @endif

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ auth()->user()->isEncargado() ? 7 : 6 }}"
                                    class="empty-state"
                                >
                                    No existen incidencias registradas.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $incidents->links() }}
            </div>

        </div>

    </div>

</section>

@endsection