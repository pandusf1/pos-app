<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Pembelian</title>
<style>
body { font-family: "Times New Roman"; font-size: 12px; }
table { width:100%; border-collapse: collapse; }
th, td { border:1px solid #000; padding:6px; font-size:11px; }
th { background:#0f172a; color:#fff; }
.text-center { text-align:center; }
.text-right { text-align:right; }
</style>
</head>
<body>

<div style="text-align:center">
    <h2>LAPORAN PEMBELIAN</h2>
    <h3>KEJORA MART</h3>
    <p>Semarang</p>
</div>

<br>

<table>
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
@foreach($data as $d)
@php $isRetur = $d->jml_beli < 0; @endphp
<tr>
    <td class="text-center">{{ $d->no_beli }}</td>
    <td class="text-center">{{ date('d-m-Y', strtotime($d->tgl_beli)) }}</td>
    <td>{{ $d->nm_sup }}</td>
    <td>{{ $d->nm_brg }}</td>
    <td class="text-center">{{ $d->jml_beli }}</td>
    <td class="text-right">Rp {{ number_format($d->harga_beli,0,',','.') }}</td>
    <td class="text-right">Rp {{ number_format($d->total,0,',','.') }}</td>
</tr>
@endforeach
</tbody>
</table>

<br><br>

<table width="100%" style="border:none">
<tr>
    <td width="60%"></td>
    <td width="40%" align="center">
        Semarang, {{ date('d F Y') }}
        <br><br><br>
        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
    </td>
</tr>
</table>

</body>
</html>