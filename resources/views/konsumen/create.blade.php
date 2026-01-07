@extends('layout')
@section('content')

<style>
    .form-card {
        background: #fff;
        border-radius: 22px;
        padding: 32px 34px 36px;
        box-shadow: 0 18px 30px rgba(15,23,42,.08);
    }

    .form-title {
        font-weight: 800;
        font-size: 20px;
        color: #0f172a;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 14px;
    }

    .btn-primary-dark {
        background: #0f172a;
        color: #fff;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
    }

    .btn-primary-dark:hover {
        background: #020617;
    }

    .btn-outline {
        border-radius: 12px;
        padding: 10px 18px;
        border: 1.5px solid #94a3b8;
        background: #fff;
        color: #334155;
        font-weight: 600;
    }

    .btn-outline:hover {
        background: #f1f5f9;
    }
</style>

<div class="form-card">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-title">Tambah Data Konsumen</div>
        <a href="{{ route('konsumen.index') }}" class="btn-outline">
            ← Kembali
        </a>
    </div>

    <!-- FORM -->
    <form method="POST" action="{{ route('konsumen.store') }}">
        @csrf

        <div class="row g-4">

            <div class="col-md-4">
                <label class="form-label">Kode Konsumen</label>
                <input type="text"
                       name="kd_kons"
                       class="form-control"
                       placeholder="Contoh: K-0001"
                       required>
            </div>

            <div class="col-md-8">
                <label class="form-label">Nama Konsumen</label>
                <input type="text"
                       name="nm_kons"
                       class="form-control"
                       placeholder="Nama lengkap konsumen"
                       required>
            </div>

            <div class="col-md-8">
                <label class="form-label">Alamat</label>
                <input type="text"
                       name="alm_kons"
                       class="form-control"
                       placeholder="Alamat konsumen">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kota</label>
                <input type="text"
                       name="kota_kons"
                       class="form-control"
                       placeholder="Kota">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kode Pos</label>
                <input type="text"
                       name="kd_pos"
                       class="form-control"
                       placeholder="Kode pos">
            </div>

            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="08xxxxxxxxxx">
            </div>

            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="email@contoh.com">
            </div>

        </div>

        <!-- BUTTON -->
        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('konsumen.index') }}" class="btn-outline">
                Batal
            </a>
            <button class="btn-primary-dark">
                Simpan Konsumen
            </button>
        </div>

    </form>

</div>

@endsection
