@extends('layout')

@section('content')

<style>
/* ===== WRAPPER ===== */
.page-wrapper {
    background: #fff;
    border-radius: 20px;
    padding: 28px 30px 34px;
    box-shadow: 0 10px 30px rgba(15,23,42,.08);
}

/* ===== HEADER ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.page-title {
    font-weight: 800;
    font-size: 20px;
    color: #0f172a;
}

/* ===== FORM ===== */
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}

.form-control {
    border-radius: 12px;
    padding: 10px 14px;
}

/* ===== IMAGE ===== */
.img-preview {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f8fafc;
}

/* ===== BUTTON ===== */
.btn-dark-custom {
    background: #0f172a;
    color: #fff;
    border-radius: 12px;
    padding: 10px 20px;
}
.btn-dark-custom:hover {
    background: #020617;
}

.btn-outline-custom {
    border-radius: 12px;
    padding: 10px 20px;
}
</style>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-title">Edit Data Barang</div>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-outline-custom">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <form action="{{ route('barang.update', $barang->kd_brg) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-md-3">
                <label class="form-label">Kode Barang</label>
                <input class="form-control" value="{{ $barang->kd_brg }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama Barang</label>
                <input name="nm_brg" class="form-control"
                       value="{{ old('nm_brg', $barang->nm_brg) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Satuan</label>
                <input name="satuan" class="form-control"
                       value="{{ old('satuan', $barang->satuan) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control"
                       value="{{ old('harga_jual', $barang->harga_jual) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control"
                       value="{{ old('harga_beli', $barang->harga_beli) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="{{ old('stok', $barang->stok) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Stok Minimum</label>
                <input type="number" name="stok_min" class="form-control"
                       value="{{ old('stok_min', $barang->stok_min) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Expired</label>
                <input type="date" name="expired" class="form-control"
                       value="{{ old('expired', $barang->expired) }}">
            </div>

            @if($barang->gambar)
            <div class="col-md-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <img src="{{ asset('gambar/'.$barang->gambar) }}" class="img-preview">
            </div>
            @endif

            <div class="col-md-3">
                <label class="form-label">Ganti Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>

        </div>

        <!-- ACTION -->
        <div class="mt-5 d-flex justify-content-end gap-3">
            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-outline-custom">
                Batal
            </a>
            <button class="btn btn-dark-custom">
                Update Barang
            </button>
        </div>

    </form>

</div>

@endsection
