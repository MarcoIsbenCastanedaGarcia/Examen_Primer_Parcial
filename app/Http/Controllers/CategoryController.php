<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service
    ) {
    }

    public function index(): View
    {
        $categories =
            Category::withCount(
                'equipment'
            )
                ->orderBy('name')
                ->paginate(15);

        return view(
            'categories.index',
            compact('categories')
        );
    }

    public function create(): View
    {
        return view(
            'categories.create'
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {
        $data =
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:categories,name',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'active' => [
                    'nullable',
                    'boolean',
                ],
            ]);

        $data['active'] =
            $request->boolean(
                'active'
            );

        $this->service->create(
            $data
        );

        return redirect()
            ->route(
                'categories.index'
            )
            ->with(
                'success',
                'Categoría registrada correctamente.'
            );
    }

    public function edit(
        Category $category
    ): View {
        return view(
            'categories.edit',
            compact('category')
        );
    }

    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $data =
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:100',

                    Rule::unique(
                        'categories',
                        'name'
                    )->ignore(
                        $category->id
                    ),
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'active' => [
                    'nullable',
                    'boolean',
                ],
            ]);

        $data['active'] =
            $request->boolean(
                'active'
            );

        $this->service->update(
            $category,
            $data
        );

        return redirect()
            ->route(
                'categories.index'
            )
            ->with(
                'success',
                'Categoría actualizada correctamente.'
            );
    }

    public function destroy(
        Category $category
    ): RedirectResponse {
        $this->service->delete(
            $category
        );

        return redirect()
            ->route(
                'categories.index'
            )
            ->with(
                'success',
                'Categoría eliminada correctamente.'
            );
    }
}