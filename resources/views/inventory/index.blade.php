@extends('layouts.app')

@section('title', 'Inventario')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Gestión de recursos
                </span>

                <h1>
                    Inventario
                </h1>

                <p>
                    Consulta los equipos, categorías, disponibilidad y
                    estado físico.
                </p>

            </div>

            @if(auth()->user()->isEncargado())

                <div class="heading-actions">

                    <a
                        href="{{ route('equipment.import') }}"
                        class="button button-secondary"
                    >
                        Carga masiva
                    </a>

                    <a
                        href="{{ route('equipment.export') }}"
                        class="button button-secondary"
                    >
                        Exportar TXT
                    </a>

                    <a
                        href="{{ route('equipment.create') }}"
                        class="button button-primary"
                    >
                        Registrar equipo
                    </a>

                </div>

            @endif

        </div>

        <div class="panel">

            <form
                method="GET"
                action="{{ route('inventory.index') }}"
                class="filter-bar"
            >

                <div class="form-group filter-search">

                    <label for="search">
                        Buscar
                    </label>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Código, equipo, marca o categoría"
                    >

                </div>

                <div class="form-group">

                    <label for="category_id">
                        Categoría
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                    >

                        <option value="">
                            Todas
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(request('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label for="availability_status">
                        Disponibilidad
                    </label>

                    <select
                        id="availability_status"
                        name="availability_status"
                    >

                        <option value="">
                            Todas
                        </option>

                        <option
                            value="disponible"
                            @selected(request('availability_status') === 'disponible')
                        >
                            Disponible
                        </option>

                        <option
                            value="reservado"
                            @selected(request('availability_status') === 'reservado')
                        >
                            Reservado
                        </option>

                        <option
                            value="prestado"
                            @selected(request('availability_status') === 'prestado')
                        >
                            Prestado
                        </option>

                        <option
                            value="no_disponible"
                            @selected(request('availability_status') === 'no_disponible')
                        >
                            No disponible
                        </option>

                    </select>

                </div>

                <div class="filter-actions">

                    <button
                        type="submit"
                        class="button button-primary"
                    >
                        Buscar
                    </button>

                    <a
                        href="{{ route('inventory.index') }}"
                        class="button button-ghost"
                    >
                        Limpiar
                    </a>

                </div>

            </form>

        </div>

        <div class="table-card">

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>
                            <th>
                                Código
                            </th>

                            <th>
                                Equipo
                            </th>

                            <th>
                                Categoría
                            </th>

                            <th>
                                Disponibilidad
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Ubicación
                            </th>

                            <th>
                                Incidencias
                            </th>

                            @if(auth()->user()->isEncargado())
                                <th>
                                    Acciones
                                </th>
                            @endif

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($equipment as $item)

                            <tr
                                class="{{ $item->active_incidents_count > 0 ? 'row-incident' : '' }}"
                            >

                                <td>
                                    <strong>
                                        {{ $item->inventory_code }}
                                    </strong>
                                </td>

                                <td>

                                    <strong>
                                        {{ $item->name }}
                                    </strong>

                                    @if($item->brand || $item->model)

                                        <span class="table-secondary">
                                            {{ $item->brand }}
                                            {{ $item->model }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $item->category->name }}
                                </td>

                                <td>

                                    <span
                                        class="status status-{{ $item->availability_status }}"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $item->availability_status)) }}
                                    </span>

                                </td>

                                <td>

                                    <span
                                        class="status status-physical-{{ $item->physical_state }}"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $item->physical_state)) }}
                                    </span>

                                </td>

                                <td>
                                    {{ $item->location ?? 'Sin especificar' }}
                                </td>

                                <td>

                                    @if($item->active_incidents_count > 0)

                                        <span class="incident-indicator">

                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2 1 21h22L12 2Zm0 5 6.92 12H5.08L12 7Zm-1 3v5h2v-5h-2Zm0 6v2h2v-2h-2Z"
                                                />
                                            </svg>

                                            {{ $item->active_incidents_count }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Sin incidencias
                                        </span>

                                    @endif

                                </td>

                                @if(auth()->user()->isEncargado())

                                    <td>

                                        <div class="table-actions">

                                            <a
                                                href="{{ route('equipment.edit', $item) }}"
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
                                                action="{{ route('equipment.destroy', $item) }}"
                                                data-confirm="¿Seguro que quieres eliminar este equipo?"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="icon-button icon-button-danger"
                                                    title="Eliminar"
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
                                    colspan="{{ auth()->user()->isEncargado() ? 8 : 7 }}"
                                    class="empty-state"
                                >
                                    No se encontraron equipos registrados.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $equipment->links() }}
            </div>

        </div>

    </div>

</section>

@endsection