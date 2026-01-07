@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-3">Laporan Retur Pembelian</h4>

    {{-- FILTER TANGGAL --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="date" name="tgl_awal" class="form-control"
                value="{{ request('tgl_awal') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="tgl_akhir" class="form-control"
                value="{{ request('tgl_akhir') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No Retur</th>
                <th>No Beli</th>
                <th>Tanggal</th>
                <th class="text-end">Total Retur</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($retur as $r)
            <tr>
                <td>{{ $r->no_retur_beli }}</td>
                <td>{{ $r->no_beli }}</td>
                <td>{{ $r->tgl_retur }}</td>
                <td class="text-end">{{ number_format($r->total_retur) }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info"
                        data-bs-toggle="collapse"
                        data-bs-target="#detail{{ $r->no_retur_beli }}">
                        Detail
                    </button>
                </td>
            </tr>

            {{-- ROW DETAIL --}}
            <tr id="detail{{ $r->no_retur_beli }}" class="collapse bg-light">
                <td colspan="5">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($r->detail as $d)
                            <tr>
                                <td>{{ $d->kd_brg }}</td>
                                <td class="text-center">{{ $d->qty_retur }}</td>
                                <td class="text-end">{{ number_format($d->harga_beli) }}</td>
                                <td class="text-end">{{ number_format($d->subtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>   {{-- 🔴 INI YANG TADI KURANG --}}
</div>
@endsection
