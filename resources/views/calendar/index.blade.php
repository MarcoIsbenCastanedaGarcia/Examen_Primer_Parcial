@extends('layouts.app')

@section('title', 'Calendario')

@section('content')

<section class="page-section">

    <div class="container">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Programación
                </span>

                <h1>
                    Calendario
                </h1>

                <p>
                    Consulta los préstamos aprobados y las entregas
                    actualmente registradas.
                </p>

            </div>

        </div>

        <div class="calendar-layout">

            <div class="calendar-card">

                <div class="calendar-header">

                    <button
                        type="button"
                        class="icon-button"
                        data-calendar-prev
                        aria-label="Mes anterior"
                    >

                        <svg viewBox="0 0 24 24">
                            <path
                                d="m15.4 7.4-1.4-1.4-6 6 6 6 1.4-1.4L10.8 12l4.6-4.6Z"
                            />
                        </svg>

                    </button>

                    <h2 data-calendar-title>
                        Calendario
                    </h2>

                    <button
                        type="button"
                        class="icon-button"
                        data-calendar-next
                        aria-label="Mes siguiente"
                    >

                        <svg viewBox="0 0 24 24">
                            <path
                                d="m8.6 16.6 1.4 1.4 6-6-6-6-1.4 1.4 4.6 4.6-4.6 4.6Z"
                            />
                        </svg>

                    </button>

                </div>

                <div class="calendar-weekdays">

                    <span>
                        Lun
                    </span>

                    <span>
                        Mar
                    </span>

                    <span>
                        Mié
                    </span>

                    <span>
                        Jue
                    </span>

                    <span>
                        Vie
                    </span>

                    <span>
                        Sáb
                    </span>

                    <span>
                        Dom
                    </span>

                </div>

                <div
                    class="calendar-grid"
                    data-calendar-grid
                ></div>

            </div>

            <aside class="calendar-sidebar">

                <h3>
                    Préstamos programados
                </h3>

                <div
                    id="loan-calendar-data"
                    data-loans='@json(
                        $loans->map(function ($loan) {
                            return [
                                "id" => $loan->id,
                                "start" => $loan->start_at->toIso8601String(),
                                "end" => $loan->end_at->toIso8601String(),
                                "status" => $loan->status,
                                "user" => $loan->user->name,
                                "equipment" => $loan->items->map(function ($item) {
                                    return $item->equipment->name;
                                })->values(),
                            ];
                        })->values()
                    )'
                ></div>

                <div class="calendar-loan-list">

                    @forelse($loans as $loan)

                        <article class="calendar-loan-card">

                            <span class="status status-{{ $loan->status }}">
                                {{ ucfirst($loan->status) }}
                            </span>

                            <strong>
                                {{ $loan->start_at->format('d/m/Y H:i') }}
                            </strong>

                            <p>
                                {{ $loan->user->name }}
                            </p>

                            <ul>

                                @foreach($loan->items as $item)
                                    <li>
                                        {{ $item->equipment->name }}
                                    </li>
                                @endforeach

                            </ul>

                        </article>

                    @empty

                        <p class="empty-state">
                            No hay préstamos programados.
                        </p>

                    @endforelse

                </div>

            </aside>

        </div>

    </div>

</section>

@endsection