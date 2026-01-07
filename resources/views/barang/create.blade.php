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

.form-control:focus {
    box-shadow: none;
    border-color: #0f172a;
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
        <div class="page-title">Tambah Data Barang</div>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-outline-custom">
            ← Kembali
        </a>
    </div>

    <!-- ERROR -->
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
    <form action="{{ route('barang.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <div class="col-md-3">
                <label class="form-label">Kode Barang</label>
                <input name="kd_brg" class="form-control"
                       placeholder="Contoh: B-0005"
                       value="{{ old('kd_brg') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama Barang</label>
                <input name="nm_brg" class="form-control"
                       value="{{ old('nm_brg') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Satuan</label>
                <input name="satuan" class="form-control"
                       value="{{ old('satuan') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control"
                       value="{{ old('harga_jual') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control"
                       value="{{ old('harga_beli') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="{{ old('stok') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Stok Minimum</label>
                <input type="number" name="stok_min" class="form-control"
                       value="{{ old('stok_min') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Expired</label>
                <input type="date" name="expired" class="form-control"
                       value="{{ old('expired') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Gambar Barang</label>
                <input type="file" name="gambar" class="form-control">
            </div>

        </div>

        <!-- ACTION -->
        <div class="mt-5 d-flex justify-content-end gap-3">
            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-outline-custom">
                Batal
            </a>
            <button class="btn btn-dark-custom">
                Simpan Barang
            </button>
        </div>

    </form>

</div>

@endsection
