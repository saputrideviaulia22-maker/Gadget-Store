
<div class="row g-3">

    {{-- Kode Produk --}}
    <div class="col-md-6">
        <label class="form-label">Kode Produk</label>
        <input
            type="text"
            name="product_code"
            class="form-control"
            value="{{ old('product_code', $product->product_code ?? '') }}"
        >
        @error('product_code')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Nama Produk --}}
    <div class="col-md-6">
        <label class="form-label">Nama Produk</label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $product->name ?? '') }}"
        >
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Kategori --}}
    <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
            <option value="">Pilih Kategori</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Merek --}}
    <div class="col-md-6">
        <label class="form-label">Merek</label>
        <input
            type="text"
            name="brand"
            class="form-control"
            value="{{ old('brand', $product->brand ?? '') }}"
        >
        @error('brand')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Harga --}}
    <div class="col-md-6">
        <label class="form-label">Harga</label>
        <input
            type="number"
            min="0"
            step="0.01"
            name="price"
            class="form-control"
            value="{{ old('price', $product->price ?? '') }}"
        >
        @error('price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Stok --}}
    <div class="col-md-6">
        <label class="form-label">Stok</label>
        <input
            type="number"
            min="0"
            name="stock"
            class="form-control"
            value="{{ old('stock', $product->stock ?? 0) }}"
        >
        @error('stock')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea
            name="description"
            class="form-control"
            rows="4"
        >{{ old('description', $product->description ?? '') }}</textarea>

        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Gambar Produk --}}
    <div class="col-md-6">
        <label class="form-label">Gambar Produk</label>
        <input
            type="file"
            name="image"
            class="form-control"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <small class="text-secondary">
            Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.
        </small>

        @error('image')
            <div>
                <small class="text-danger">{{ $message }}</small>
            </div>
        @enderror

        {{-- Preview Gambar --}}
        @if(!empty($product?->image))
            <div class="mt-3">
                <p class="mb-2">Gambar Saat Ini:</p>
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="Gambar Produk"
                    class="img-thumbnail"
                    style="max-height: 120px;"
                >
            </div>
        @endif
    </div>

</div>
