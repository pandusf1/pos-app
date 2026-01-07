@extends('layout')
@section('content')

@php
$total = $jual->detail->sum(fn($d) => $d->harga_jual * $d->jml_jual);
@endphp


<div class="form-card">

    <div class="d-flex justify-content-between mb-4">
        <h5 class="fw-bold">
        Nota Penjualan #{{ $jual->no_jual }}
        </h5>
        <a href="{{ route('jual.index') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    <p><b>Tanggal:</b> {{ $jual->tgl_jual }}</p>
    <p><b>Konsumen:</b> {{ $jual->konsumen->nm_kons }}</p>

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
        @foreach($jual->detail as $d)
            <tr>
                <td>{{ $d->barang->nm_brg }}</td>
                <td>Rp {{ number_format($d->harga_jual) }}</td>
                <td class="text-center">{{ $d->jml_jual }}</td>
                <td class="text-end">
                    Rp {{ number_format($d->harga_jual * $d->jml_jual) }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-end fw-bold">TOTAL</td>
            <td class="text-end fw-bold">
                Rp {{ number_format($total) }}
            </td>
        </tr>
        </tbody>
    </table>

    <a href="{{ route('jual.cetak', $jual->no_jual) }}"
    target="_blank"
    class="btn btn-dark">
    Cetak Bukti
    </a>


</div>
@endsection