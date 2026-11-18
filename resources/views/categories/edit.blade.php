
@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="name" class="form-control"
            value="{{ old('name', $category->name) }}" required>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Jumlah Produk (Bisa Diubah)</label>
        <input
            type="number"
            name="product_count"
            class="form-control"
            min="0"
            value="{{ old('product_count', $category->products_count) }}"
            required
        >
        @error('product_count')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Status Kategori</label>
        <select name="status" class="form-control" required>
            <option value="Aktif" {{ old('status', $category->status) == 'Aktif' ? 'selected' : '' }}>
                Aktif
            </option>
            <option value="Tidak Aktif" {{ old('status', $category->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                Tidak Aktif
            </option>
        </select>
        @error('status')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>

</form>

@endsection
