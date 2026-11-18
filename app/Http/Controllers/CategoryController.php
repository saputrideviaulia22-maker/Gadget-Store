<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $category->loadCount('products');

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'product_count' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($category, $validated) {

            $category->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'status' => $validated['status'],
            ]);

            $currentCount = $category->products()->count();
            $targetCount = (int) $validated['product_count'];

            if ($targetCount > $currentCount) {
                $needed = $targetCount - $currentCount;

                $otherProducts = DB::table('products')
                    ->where('category_id', '!=', $category->id)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->limit($needed)
                    ->get(['id']);

                if ($otherProducts->count() < $needed) {
                    throw new \RuntimeException(
                        'Produk dari kategori lain tidak mencukupi.'
                    );
                }

                DB::table('products')
                    ->whereIn('id', $otherProducts->pluck('id'))
                    ->update([
                        'category_id' => $category->id,
                        'updated_at' => now(),
                    ]);
            }

            if ($targetCount < $currentCount) {
                $excess = $currentCount - $targetCount;

                $destination = Category::where('id', '!=', $category->id)
                    ->orderBy('id')
                    ->first();

                if (!$destination && $excess > 0) {
                    throw new \RuntimeException(
                        'Tidak ada kategori tujuan.'
                    );
                }

                $products = $category->products()
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->limit($excess)
                    ->get();

                foreach ($products as $product) {
                    $product->update([
                        'category_id' => $destination->id,
                    ]);
                }
            }
        });

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Kategori masih digunakan oleh produk.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
