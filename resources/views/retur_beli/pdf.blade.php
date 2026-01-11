<!DOCTYPE html>
<html>
<head>
    <title>Laporan Retur Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>

<h3 align="center">LAPORAN RETUR PEMBELIAN</h3>

<table>
    <thead>
        <tr>
            <th>No Retur</th>
            <th>No Beli</th>
            <th>Tanggal</th>
            <th>Kode Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
    @php $grandTotal = 0; @endphp

    @foreach($retur as $r)
        @foreach($r->detail as $d)
        @php $grandTotal += $d->subtotal; @endphp
        <tr>
            <td>{{ $r->no_retur_beli }}</td>
            <td>{{ $r->no_beli }}</td>
            <td>{{ $r->tgl_retur }}</td>
            <td>{{ $d->kd_brg }}</td>
            <td align="center">{{ $d->qty_retur }}</td>
            <td align="right">{{ number_format($d->harga_beli, 0, ',', '.') }}</td>
            <td align="right">{{ number_format($d->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    @endforeach
    </tbody>

    @if($grandTotal > 0)
    <tfoot>
        <tr>
            <td colspan="6" align="right">TOTAL RETUR</td>
            <td align="right">
                Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </td>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>
