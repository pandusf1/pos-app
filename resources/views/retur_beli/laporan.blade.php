@extends('layout')
@section('content')

<div class="glass-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0">Laporan Retur Pembelian</h4>
        <div class="d-flex gap-2">
            {{-- Sesuaikan route export jika sudah ada --}}
            <div class="d-flex gap-2">
                <a href="{{ route('laporan.retur.pembelian.pdf', request()->all()) }}"
                class="btn btn-danger btn-sm">
                    Export PDF
                </a>

                <a href="{{ route('laporan.retur.pembelian.excel', request()->all()) }}"
                class="btn btn-success btn-sm">
                    Export Excel
                </a>
            </div>

        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="small text-muted">Dari Tanggal</label>
                <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
            </div>
            <div class="col-md-3">
                <label class="small text-muted">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-dark mt-auto">Filter</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary mt-auto">Reset</a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center">No Retur</th>
                    <th class="text-center">No Beli</th>
                    <th>Supplier</th> {{-- Ganti label sesuai data Anda --}}
                    <th>Barang</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($retur as $r)
                @foreach($r->detail as $d)
                @php $grandTotal += $d->subtotal; @endphp
                <tr>
                    <td class="text-center fw-bold">{{ $r->no_retur_beli }}</td>
                    <td class="text-center text-muted small">{{ $r->no_beli }}</td>
                    <td>{{ $r->Beli->supplier->nm_sup ?? '-' }}</td>
                    <td>{{ $d->barang->nm_brg ?? $d->kd_brg }}</td>
                    <td class="text-center fw-bold">{{ $d->qty_retur }}</td>
                    <td class="text-end">Rp {{ number_format($d->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-end fw-semibold">
                        Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Data tidak ditemukan</td>
                </tr>
            @endforelse
            </tbody>
            @if($grandTotal > 0)
            <tfoot class="table-light">
                <tr>
                    <td colspan="6" class="text-end fw-bold">TOTAL RETUR</td>
                    <td class="text-end fw-bold text-danger">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
    
    {{-- Jika menggunakan pagination --}}
    @if(method_exists($retur, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $retur->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
