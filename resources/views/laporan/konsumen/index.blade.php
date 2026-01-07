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
    :root {
        --navy: #0f172a;
        --muted: #64748b;
    }

    .glass-card {
        background: #fff;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 18px 30px rgba(15,23,42,.08);
    }

    .page-title {
        font-weight: 800;
        color: var(--navy);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table thead th {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--muted);
        border: none;
        padding-bottom: 10px;
        text-align: center;
    }

    .table thead th a {
        color: var(--muted) !important;
        font-weight: 700;
        text-decoration: none;
    }

    .table thead th a:hover {
        color: var(--navy) !important;
    }

    .table tbody tr {
        background: #fff;
        box-shadow: 0 6px 14px rgba(15,23,42,.05);
        transition: .2s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
    }

    .table td {
        border: none;
        padding: 14px;
        vertical-align: middle;
        white-space: nowrap;
    }
</style>

<div class="glass-card">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0">Laporan Konsumen</h4>

        <div class="d-flex gap-2">
            <a href="{{ url('/laporan/konsumen/pdf?' . request()->getQueryString()) }}"
               class="btn btn-danger btn-sm rounded-3">
                Export PDF
            </a>
            <a href="{{ url('/laporan/konsumen/excel?' . request()->getQueryString()) }}"
               class="btn btn-success btn-sm rounded-3">
                Export Excel
            </a>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">

            <div class="col-md-5">
                <label class="small text-muted">Pencarian</label>
                <input type="text" name="search"
                       class="form-control"
                       placeholder="Kode / Nama Konsumen/alamat/email"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <label class="small text-muted">Per Page</label>
                <input type="number" name="per_page"
                       class="form-control"
                       min="5" max="100"
                       value="{{ request('per_page',10) }}">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-dark">Filter</button>
            </div>

            <div class="col-md-1 d-grid">
                <a href="{{ route('laporan.konsumen.index') }}"
                   class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>

        </div>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center">Kode</th>
                    <th>Nama Konsumen</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th class="text-center">Kode Pos</th>
                    <th class="text-center">No Telp</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $d)
                <tr>
                    <td class="text-center fw-bold">{{ $d->kd_kons }}</td>
                    <td class="fw-semibold">{{ $d->nm_kons }}</td>
                    <td>{{ $d->alm_kons }}</td>
                    <td>{{ $d->kota_kons }}</td>
                    <td class="text-center">{{ $d->kd_pos }}</td>
                    <td class="text-center">{{ $d->phone }}</td>
                    <td>{{ $d->email }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Data konsumen tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
