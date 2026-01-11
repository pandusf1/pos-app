<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Retur Pembelian</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 12px; }
        .kop { text-align: center; }
        .kop h2 { margin: 0; font-size: 20px; }
        .kop p { margin: 3px 0; }

        .line { border-top: 2px solid #000; margin: 10px 0 2px; }
        .line-thin { border-top: 1px solid #000; margin-bottom: 20px; }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }

        table { width: 100%; border-collapse: collapse; }
        th {
            background: #0f172a;
            color: #fff;
            padding: 6px;
            font-size: 11px;
        }
        td {
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 11px;
        }

        tfoot td { font-weight: bold; background: #f1f5f9; }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<div class="kop">
    <h2>LAPORAN RETUR PEMBELIAN</h2>
    <h2>KEJORA MART</h2>
    <p>Jl. Bintang No 36, Semarang</p>
</div>

<div class="line"></div>
<div class="line-thin"></div>

<div class="title">LAPORAN RETUR PEMBELIAN</div>

<table>
    <thead>
        <tr>
            <th>No Retur</th>
            <th>No Beli</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Qty Retur</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($retur as $r)
            @foreach($r->detail as $d)
            <tr>
                <td class="text-center">{{ $r->no_retur_beli }}</td>
                <td class="text-center">{{ $r->no_beli }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($r->tgl_retur)) }}</td>
                <td>{{ $d->barang->nm_brg }}</td>
                <td class="text-center">{{ $d->qty_retur }}</td>
                <td class="text-right">Rp {{ number_format($d->harga_beli,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
            </tr>
            @php $total += $d->subtotal; @endphp
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-right">TOTAL KESELURUHAN</td>
            <td class="text-right">Rp {{ number_format($total,0,',','.') }}</td>
        </tr>
    </tfoot>
</table>

<br><br>

<table width="100%" style="border:none;">
    <tr>
        <td width="60%"></td>
        <td width="40%" align="center">
            Semarang, {{ date('d F Y') }}
        </td>
    </tr>
</table>

<br><br>

<table width="100%" style="border:none;">
    <tr>
        <td width="50%" align="center">Dibuat oleh,</td>
        <td width="50%" align="center">Mengetahui,</td>
    </tr>
    <tr><td height="70"></td><td></td></tr>
    <tr>
        <td align="center"><strong>{{ auth()->user()->name ?? 'Admin' }}</strong></td>
        <td align="center"><strong>Pimpinan</strong></td>
    </tr>
</table>

</body>
</html>
