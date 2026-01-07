@extends('layout')
@section('content')

@php
    $total = $beli->detail->sum(fn($d) => $d->harga_beli * $d->jml_beli);
@endphp

<div class="note-card">

    <div class="d-flex justify-content-between mb-4">
        <h5 class="fw-bold">
        Nota Pembelian #{{ $beli->no_beli }}
        </h5>


        <a href="{{ route('beli.index') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    <p><b>Tanggal:</b> {{ $beli->tgl_beli }}</p>
    <p><b>Supplier:</b> {{ optional($beli->supplier)->nm_sup ?? '-' }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($beli->detail as $d)
            <tr>
                <td>{{ optional($d->barang)->nm_brg ?? '-' }}</td>
                <td>Rp {{ number_format($d->harga_beli,0,',','.') }}</td>
                <td class="text-center">{{ $d->jml_beli }}</td>
                <td class="text-end">
                    Rp {{ number_format($d->harga_beli * $d->jml_beli,0,',','.') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-end fw-bold">TOTAL</td>
            <td class="text-end fw-bold">
                Rp {{ number_format($total,0,',','.') }}
            </td>
        </tr>
        </tbody>
    </table>

    <a href="{{ route('beli.cetak', $beli->no_beli) }}"
        target="_blank"
        class="btn btn-dark">
        Cetak Bukti
    </a>

</div>
@endsection