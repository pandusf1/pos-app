@php
function sortLink($label, $field) {
    $isActive = request('sort') === $field;
    $dir = request('dir') === 'asc' ? 'desc' : 'asc';
    $arrow = $isActive ? (request('dir') === 'asc' ? '▲' : '▼') : '';
    $query = array_merge(request()->query(), [
        'sort' => $field,
        'dir'  => $dir
    ]);
    return '<a href="?' . http_build_query($query) . '">' . $label . ' ' . $arrow . '</a>';
}
@endphp

@extends('layout')
@section('content')

<style>
.badge-retur {
    background: #dc2626;
    color: #fff;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 8px;
    font-weight: 700;
}
.badge-jual {
    background: #16a34a;
    color: #fff;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 8px;
    font-weight: 700;
}
</style>

<div class="glass-card">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0">Laporan Penjualan</h4>

        <div class="d-flex gap-2">
            <a href="{{ url('/laporan/penjualan/pdf?' . request()->getQueryString()) }}"
               class="btn btn-danger btn-sm">Export PDF</a>
            <a href="{{ url('/laporan/penjualan/excel?' . request()->getQueryString()) }}"
               class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

    {{-- FILTER (TIDAK DIUBAH) --}}
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="small text-muted">Dari</label>
                <input type="date" name="start_date" class="form-control"
                       value="{{ request('start_date') }}">
            </div>

            <div class="col-md-2">
                <label class="small text-muted">Sampai</label>
                <input type="date" name="end_date" class="form-control"
                       value="{{ request('end_date') }}">
            </div>

            <div class="col-md-4">
                <label class="small text-muted">Pencarian</label>
                <input type="text" name="search" class="form-control"
                       placeholder="No jual / konsumen / barang"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <label class="small text-muted">Per Page</label>
                <input type="number" name="per_page" class="form-control"
                       min="5" max="100"
                       value="{{ request('per_page',10) }}">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-dark">Filter</button>
            </div>

            <div class="col-md-1 d-grid">
                <a href="{{ route('laporan.penjualan.index') }}"
                   class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center">No Jual</th>
                    <th class="text-center">Tanggal</th>
                    <th>Jenis</th>
                    <th>Konsumen</th>
                    <th>Barang</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $d)
               
                <tr>
                    <td class="text-center fw-bold">{{ $d->no_jual }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($d->tgl_jual)) }}</td>
                    <td>{{ $d->nm_kons }}</td>
                    <td>{{ $d->nm_brg }}</td>
                    <td class="text-center fw-bold">{{ $d->jml_jual }}</td>
                    <td class="text-center">Rp {{ number_format($d->harga_jual,0,',','.') }}</td>
                    <td class="text-center fw-semibold">
                        Rp {{ number_format($d->total,0,',','.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        Data tidak ditemukan
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