<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ringkasan dashboard
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStock = (int) Product::sum('stock');

        // Produk dengan stok menipis
        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        // Komposisi kondisi stok
        $stockStatus = [
            Product::where('stock', '<=', 5)->count(),
            Product::whereBetween('stock', [6, 20])->count(),
            Product::where('stock', '>', 20)->count(),
        ];

        // Estimasi nilai persediaan
        $inventoryValue = (float) Product::selectRaw(
            'COALESCE(SUM(price * stock), 0) as total'
        )->value('total');

        // Data semua kategori untuk grafik
        $categoryStats = Category::query()
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(products.id) as product_count'),
                DB::raw('COALESCE(SUM(products.stock), 0) as stock_total')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();

        // Grafik batang: jumlah produk per kategori
        $categoryLabels = $categoryStats->pluck('name');
        $categoryProductCounts = $categoryStats->pluck('product_count');

        // Grafik lingkaran: semua kategori
        $categoryPieData = $categoryStats->pluck('product_count');

        // Grafik stok per kategori
        $categoryStockData = $categoryStats->pluck('stock_total');

        // Produk terbaru
        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalStock',
            'lowStockProducts',
            'stockStatus',
            'inventoryValue',
            'categoryStats',
            'categoryLabels',
            'categoryProductCounts',
            'categoryPieData',
            'categoryStockData',
            'latestProducts'
        ));
    }
}