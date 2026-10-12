<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(
        Request $request
    ): View {
        $query =
            Equipment::query()
                ->with('category')
                ->withCount([
                    'incidents as active_incidents_count'
                    => function (
                        $query
                    ): void {
                        $query->whereNotIn(
                            'status',
                            ['cerrada']
                        );
                    },
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
                            'inventory_code',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'brand',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'model',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'category',
                            function (
                                $query
                            ) use (
                                $search
                            ): void {
                                $query->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                }
            );
        }

        if (
            $request->filled(
                'category_id'
            )
        ) {
            $query->where(
                'category_id',
                $request->integer(
                    'category_id'
                )
            );
        }

        if (
            $request->filled(
                'availability_status'
            )
        ) {
            $query->where(
                'availability_status',
                $request->string(
                    'availability_status'
                )->toString()
            );
        }

        $equipment =
            $query
                ->orderBy(
                    'inventory_code'
                )
                ->paginate(15)
                ->withQueryString();

        $categories =
            Category::where(
                'active',
                true
            )
                ->orderBy('name')
                ->get();

        return view(
            'inventory.index',
            compact(
                'equipment',
                'categories'
            )
        );
    }
}