@extends('layouts.app')

@section('title', 'Solicitudes de préstamo')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Administración
                </span>

                <h1>
                    Tabla de solicitudes
                </h1>

                <p>
                    Revisa, aprueba o rechaza solicitudes y registra
                    entregas y devoluciones.
                </p>

            </div>

        </div>

        <div class="panel">

            <form
                method="GET"
                action="{{ route('loans.index') }}"
                class="search-inline"
            >

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar solicitante, estado o motivo"
                >

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Buscar
                </button>

                <a
                    href="{{ route('loans.index') }}"
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
                                Folio
                            </th>

                            <th>
                                Solicitante
                            </th>

                            <th>
                                Equipos
                            </th>

                            <th>
                                Periodo
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

                        @forelse($loans as $loan)

                            <tr>

                                <td>
                                    #{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>

                                    <strong>
                                        {{ $loan->user->name }}
                                    </strong>

                                    <span class="table-secondary">
                                        {{ $loan->user->email }}
                                    </span>

                                </td>

                                <td>

                                    <ul class="compact-list">

                                        @foreach($loan->items as $item)

                                            <li>
                                                {{ $item->equipment->name }}

                                                <small>
                                                    {{ $item->equipment->inventory_code }}
                                                </small>
                                            </li>

                                        @endforeach

                                    </ul>

                                </td>

                                <td>

                                    <strong>
                                        {{ $loan->start_at->format('d/m/Y H:i') }}
                                    </strong>

                                    <span class="table-secondary">
                                        Hasta
                                        {{ $loan->end_at->format('d/m/Y H:i') }}
                                    </span>

                                </td>

                                <td>

                                    <span class="status status-{{ $loan->status }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>

                                </td>

                                <td>

                                    <div class="loan-actions">

                                        @if($loan->status === 'pendiente')

                                            <form
                                                method="POST"
                                                action="{{ route('loans.approve', $loan) }}"
                                                data-confirm="¿Aprobar esta solicitud de préstamo?"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    class="button button-small button-success"
                                                    type="submit"
                                                >
                                                    Aprobar
                                                </button>

                                            </form>

                                            <button
                                                type="button"
                                                class="button button-small button-danger"
                                                data-reject-open="{{ $loan->id }}"
                                            >
                                                Rechazar
                                            </button>

                                        @endif

                                        @if($loan->status === 'aprobado')

                                            <form
                                                method="POST"
                                                action="{{ route('loans.deliver', $loan) }}"
                                                data-confirm="¿Registrar la entrega de este préstamo?"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="button button-small button-primary"
                                                >
                                                    Registrar entrega
                                                </button>

                                            </form>

                                        @endif

                                        @if($loan->status === 'entregado')

                                            <form
                                                method="POST"
                                                action="{{ route('loans.return', $loan) }}"
                                                data-confirm="¿Registrar la devolución de este préstamo?"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="button button-small button-secondary"
                                                >
                                                    Registrar devolución
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                    @if($loan->status === 'pendiente')

                                        <div
                                            class="reject-box"
                                            data-reject-box="{{ $loan->id }}"
                                            hidden
                                        >

                                            <form
                                                method="POST"
                                                action="{{ route('loans.reject', $loan) }}"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <textarea
                                                    name="rejection_reason"
                                                    rows="3"
                                                    placeholder="Motivo del rechazo"
                                                    required
                                                ></textarea>

                                                <button
                                                    type="submit"
                                                    class="button button-small button-danger"
                                                >
                                                    Confirmar rechazo
                                                </button>

                                            </form>

                                        </div>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="6"
                                    class="empty-state"
                                >
                                    No hay solicitudes registradas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $loans->links() }}
            </div>

        </div>

    </div>

</section>

@endsection