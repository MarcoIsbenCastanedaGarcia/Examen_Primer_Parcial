@extends('layouts.app')

@section('title', 'Mis préstamos')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Seguimiento
                </span>

                <h1>
                    Mis préstamos
                </h1>

                <p>
                    Consulta el estado de las solicitudes que has realizado.
                </p>

            </div>

            <a
                href="{{ route('loans.create') }}"
                class="button button-primary"
            >
                Nueva solicitud
            </a>

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
                                Equipos
                            </th>

                            <th>
                                Inicio
                            </th>

                            <th>
                                Devolución
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Motivo
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
                                    {{ $loan->start_at->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    {{ $loan->end_at->format('d/m/Y H:i') }}
                                </td>

                                <td>

                                    <span class="status status-{{ $loan->status }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>

                                    @if($loan->status === 'rechazado' && $loan->rejection_reason)

                                        <span class="table-secondary">
                                            {{ $loan->rejection_reason }}
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $loan->purpose }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="empty-state"
                                >
                                    Todavía no has realizado solicitudes.
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