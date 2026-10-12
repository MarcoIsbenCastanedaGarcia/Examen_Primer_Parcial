<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $loans =
            Loan::with([
                'user',
                'items.equipment',
            ])
                ->whereIn(
                    'status',
                    [
                        'aprobado',
                        'entregado',
                    ]
                )
                ->orderBy(
                    'start_at'
                )
                ->get();

        return view(
            'calendar.index',
            compact('loans')
        );
    }
}