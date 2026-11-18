
@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Kategori Produk</h3>

    <a class="btn btn-primary" href="{{ route('categories.create') }}">
        Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>

                            <td>{{ $category->description }}</td>

                            <td>{{ $category->products_count }}</td>

                            <td>
                                @if($category->status == 'Aktif')
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a
                                    class="btn btn-sm btn-warning"
                                    href="{{ route('categories.edit', $category) }}">
                                    Edit
                                </a>

                                <form
                                    class="d-inline"
                                    method="POST"
                                    action="{{ route('categories.destroy', $category) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus kategori?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}

    </div>
</div>

@endsection
