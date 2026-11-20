
@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-gray-800 mb-1">Data Produk</h3>
            <p class="text-muted mb-0">
                Kelola data produk Gadget Store.
            </p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Produk
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- PENCARIAN DAN FILTER --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row g-3">

                    <div class="col-md-5">
                        <label class="form-label">Cari Produk</label>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control"
                            placeholder="Cari kode, nama, atau merek..."
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(request('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABEL PRODUK --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">
                Daftar Produk
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Gambar</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Merek</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($products as $product)

                            <tr>
                                {{-- NOMOR --}}
                                <td>
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                {{-- GAMBAR --}}
                                <td>
                                    @if($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="rounded"
                                            style="width: 48px; height: 48px; object-fit: cover;"
                                        >
                                    @else
                                        <div
                                            class="bg-light text-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px; font-size: 11px;"
                                        >
                                            No Img
                                        </div>
                                    @endif
                                </td>

                                {{-- KODE PRODUK --}}
                                <td>{{ $product->product_code }}</td>

                                {{-- NAMA PRODUK --}}
                                <td class="fw-semibold">
                                    {{ $product->name }}
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    {{ $product->category?->name ?? '-' }}
                                </td>

                                {{-- MEREK --}}
                                <td>{{ $product->brand ?? '-' }}</td>

                                {{-- HARGA --}}
                                <td>
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                </td>

                                {{-- STOK --}}
                                <td>
                                    <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('products.destroy', $product) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-box-open fa-2x text-muted mb-2"></i>

                                    <p class="text-muted mb-0">
                                        Belum ada data produk.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
