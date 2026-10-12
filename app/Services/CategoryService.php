<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(
        Category $category,
        array $data
    ): Category {
        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): void
    {
        if ($category->equipment()->exists()) {
            throw ValidationException::withMessages([
                'category' =>
                    'No se puede eliminar la categoría porque tiene equipos registrados.',
            ]);
        }

        $category->delete();
    }
}