<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ReportController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        $totalProduk = $products->count();

        $totalStok = $products->sum('stock');

        $stokMenipis = $products->where('stock', '<=', 5);

        $stokHabis = $products->where('stock', 0);

        $nilaiPersediaan = $products->sum(function ($product) {
            return $product->price * $product->stock;
        });

        return view('reports.index', compact(
            'products',
            'totalProduk',
            'totalStok',
            'stokMenipis',
            'stokHabis',
            'nilaiPersediaan'
        ));
    }
}