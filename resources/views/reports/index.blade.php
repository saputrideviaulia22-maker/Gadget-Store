@extends('layouts.app')

@section('title', 'Laporan Inventaris')
@section('page-heading', 'Laporan Inventaris')

@section('action-button')
    <button onclick="window.print()" class="btn btn-primary">
        <i class="fas fa-print"></i> Cetak Laporan
    </button>
@endsection

@section('content')

<div class="row mb-4">

    <!-- Total Produk -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Produk
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $totalProduk }}
                </div>
            </div>
        </div>
    </div>

    <!-- Total Stok -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Unit Stok
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ number_format($totalStok, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Stok Menipis
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $stokMenipis->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Habis -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                    Stok Habis
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $stokHabis->count() }}
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Nilai Persediaan -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h5 class="font-weight-bold text-primary">
            Estimasi Nilai Persediaan
        </h5>

        <h3 class="font-weight-bold text-gray-800">
            Rp {{ number_format($nilaiPersediaan, 0, ',', '.') }}
        </h3>
    </div>
</div>

<!-- Tabel Laporan -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data Inventaris Produk
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Nilai Persediaan</th>
                        <th>Status Stok</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $product->product_code }}</td>

                            <td>{{ $product->name }}</td>

                            <td>
                                {{ $product->category->name ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td>{{ $product->stock }}</td>

                            <td>
                                Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($product->stock == 0)
                                    <span class="badge badge-danger">Habis</span>
                                @elseif($product->stock <= 5)
                                    <span class="badge badge-warning">Menipis</span>
                                @else
                                    <span class="badge badge-success">Tersedia</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data produk.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
    @media print {

        #accordionSidebar,
        .topbar,
        footer,
        .scroll-to-top,
        .btn,
        .sidebar,
        .page-heading {
            display: none !important;
        }

        #content-wrapper,
        #content,
        body {
            background: white !important;
        }

        .container-fluid {
            width: 100% !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        body {
            font-size: 12px;
        }
    }
</style>
@endpush