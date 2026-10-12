<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function __construct(
        private readonly LoanService $service
    ) {
    }

    public function index(
        Request $request
    ): View {
        $query =
            Loan::with([
                'user',
                'items.equipment',
                'reviewer',
            ]);

        if ($request->filled('search')) {
            $search =
                trim(
                    $request->string(
                        'search'
                    )->toString()
                );

            $query->where(
                function (
                    $query
                ) use (
                    $search
                ): void {
                    $query
                        ->where(
                            'purpose',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'status',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'user',
                            function (
                                $query
                            ) use (
                                $search
                            ): void {
                                $query
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'email',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }

        $loans =
            $query
                ->orderByDesc(
                    'requested_at'
                )
                ->paginate(15)
                ->withQueryString();

        return view(
            'loans.index',
            compact('loans')
        );
    }

    public function myLoans(): View
    {
        $loans =
            Loan::with(
                'items.equipment'
            )
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->orderByDesc(
                    'requested_at'
                )
                ->paginate(15);

        return view(
            'loans.mine',
            compact('loans')
        );
    }

    public function create(): View
    {
        $equipment =
            Equipment::with('category')
                ->whereNotIn(
                    'physical_state',
                    [
                        'danado',
                        'mantenimiento',
                        'baja',
                    ]
                )
                ->orderBy('name')
                ->get();

        return view(
            'loans.create',
            compact('equipment')
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $data =
            $request->validate([
                'equipment_ids' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'equipment_ids.*' => [
                    'required',
                    'integer',
                    'distinct',
                    'exists:equipment,id',
                ],

                'start_at' => [
                    'required',
                    'date',
                ],

                'end_at' => [
                    'required',
                    'date',
                    'after:start_at',
                ],

                'purpose' => [
                    'required',
                    'string',
                    'min:5',
                    'max:1000',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);

        $this->service
            ->requestLoan(
                Auth::user(),
                $data
            );

        return redirect()
            ->route(
                'loans.mine'
            )
            ->with(
                'success',
                'La solicitud de préstamo fue enviada correctamente.'
            );
    }

    public function approve(
        Loan $loan
    ): RedirectResponse {
        $this->service->approve(
            $loan,
            Auth::user()
        );

        return back()->with(
            'success',
            'Solicitud aprobada correctamente.'
        );
    }

    public function reject(
        Request $request,
        Loan $loan
    ): RedirectResponse {
        $data =
            $request->validate([
                'rejection_reason' => [
                    'required',
                    'string',
                    'min:5',
                    'max:1000',
                ],
            ]);

        $this->service->reject(
            $loan,
            Auth::user(),
            $data[
                'rejection_reason'
            ]
        );

        return back()->with(
            'success',
            'Solicitud rechazada correctamente.'
        );
    }

    public function deliver(
        Request $request,
        Loan $loan
    ): RedirectResponse {
        $data =
            $request->validate([
                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);

        $this->service->deliver(
            $loan,
            Auth::user(),
            $data['notes']
            ?? null
        );

        return back()->with(
            'success',
            'La entrega del equipo fue registrada correctamente.'
        );
    }

    public function returnLoan(
        Request $request,
        Loan $loan
    ): RedirectResponse {
        $data =
            $request->validate([
                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);

        $this->service
            ->returnLoan(
                $loan,
                Auth::user(),
                $data['notes']
                ?? null
            );

        return back()->with(
            'success',
            'La devolución fue registrada correctamente.'
        );
    }
}