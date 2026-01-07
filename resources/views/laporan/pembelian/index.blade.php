@extends('layout')
@section('content')

<style>
:root {
    --navy: #0f172a;
    --muted: #64748b;
}
.glass-card {
    background:#fff;
    border-radius:18px;
    padding:28px;
    box-shadow:0 18px 30px rgba(15,23,42,.08);
}
.page-title {
    font-weight:800;
    color:var(--navy);
}
.table {
    border-collapse:separate;
    border-spacing:0 8px;
}
.table thead th {
    font-size:.75rem;
    text-transform:uppercase;
    letter-spacing:.1em;
    color:var(--muted);
    border:none;
    padding-bottom:10px;
    text-align:center;
}
.table tbody tr {
    background:#fff;
    box-shadow:0 6px 14px rgba(15,23,42,.05);
}
.table td {
    border:none;
    padding:14px;
    vertical-align:middle;
    white-space:nowrap;
}
.badge-beli {
    background:#16a34a;
    color:#fff;
}

</style>

<div class="glass-card">

    <div class="d-flex justify-content-between mb-4">
        <h4 class="page-title">Laporan Pembelian</h4>

        <div class="d-flex gap-2">
            <a href="{{ url('/laporan/pembelian/pdf?' . request()->getQueryString()) }}"
               class="btn btn-danger btn-sm">Export PDF</a>
            <a href="{{ url('/laporan/pembelian/excel?' . request()->getQueryString()) }}"
               class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="small text-muted">Dari</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label class="small text-muted">Sampai</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <label class="small text-muted">Pencarian</label>
                <input type="text" name="search" class="form-control"
                       placeholder="No beli / supplier / barang"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="small text-muted">Per Page</label>
                <input type="number" name="per_page" class="form-control"
                       value="{{ request('per_page',10) }}">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-dark">Filter</button>
            </div>
            <div class="col-md-1 d-grid">
                <a href="{{ route('laporan.pembelian.index') }}"
                   class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No Beli</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $d)
            @php $isRetur = $d->jml_beli < 0; @endphp
            <tr>
                <td class="text-center fw-bold">{{ $d->no_beli }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($d->tgl_beli)) }}</td>
                <td>{{ $d->nm_sup }}</td>
                <td>{{ $d->nm_brg }}</td>
                <td class="text-center fw-bold">{{ $d->jml_beli }}</td>
                <td class="text-end">Rp {{ number_format($d->harga_beli,0,',','.') }}</td>
                <td class="text-end fw-semibold">
                Rp {{ number_format($d->total,0,',','.') }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    Data pembelian tidak ditemukan
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection