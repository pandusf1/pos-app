<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Retur Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h2>LAPORAN RETUR PENJUALAN</h2>

@if($tgl_awal && $tgl_akhir)
<p>Periode: {{ $tgl_awal }} s/d {{ $tgl_akhir }}</p>
@endif

<table>
    <thead>
        <tr>
            <th>No Retur</th>
            <th>Tanggal</th>
            <th>No Jual</th>
            <th>Konsumen</th>
            <th>Barang</th>
            <th>Qty</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($retur as $r)
            @foreach($r->detail as $d)
            @php $total += $d->subtotal; @endphp
            <tr>
                <td>{{ $r->no_retur_jual }}</td>
                <td>{{ $r->tgl_retur }}</td>
                <td>{{ $r->no_jual }}</td>
                <td>{{ $r->jual->konsumen->nm_kons ?? '-' }}</td>
                <td>{{ $d->barang->nm_brg ?? $d->kd_brg }}</td>
                <td class="text-center">{{ $d->qty_retur }}</td>
                <td class="text-right">{{ number_format($d->subtotal) }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" class="text-right">TOTAL</th>
            <th class="text-right">{{ number_format($total) }}</th>
        </tr>
    </tfoot>
</table>

</body>
</html>
