<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Struk Pembelian</title>
<style>
body
{
    font-family: monospace;
    width: 220px; /* 58mm */
    margin: 0 auto;
    font-size: 12px;
    line-height: 1.4;
}
.center{text-align:center;}
.right{text-align:right;}
.bold{font-weight:bold;}
.small{font-size:11px;}
.line{
    border-top:1px dashed #000;
    margin:6px 0;
}
.item-row{
    display:flex;
    justify-content:space-between;
}
</style>
</head>
<body>

<!-- HEADER TOKO -->
<div class="center bold">KEJORA MART</div>
<div class="center small">
Jl. Bintang No. 36 Semarang<br>
Telp: (0271) 123-456
</div>

<div class="line"></div>

<!-- INFO PEMBELIAN -->
<div>No : {{ $beli->no_beli }}</div>
<div>Tgl: {{ $beli->tgl_beli }}</div>
<div>Supplier:</div>
<div class="bold">
    {{ optional($beli->supplier)->nm_sup ?? '-' }}
</div>

<div class="line"></div>

<!-- DETAIL BARANG -->
@php $total = 0; @endphp
@foreach($beli->detail as $d)
@php
    $sub = $d->jml_beli * $d->harga_beli;
    $total += $sub;
@endphp

<div>{{ optional($d->barang)->nm_brg ?? '-' }}</div>
<div class="item-row">
    <span>{{ $d->jml_beli }} x {{ number_format($d->harga_beli,0,',','.') }}</span>
    <span>{{ number_format($sub,0,',','.') }}</span>
</div>
@endforeach

<div class="line"></div>

<!-- TOTAL -->
<div class="item-row bold">
    <span>TOTAL</span>
    <span>Rp {{ number_format($total,0,',','.') }}</span>
</div>

<div class="line"></div>

<!-- FOOTER -->
<div class="center small">
Bukti Pembelian Barang<br>
Harap simpan struk ini<br>
sebagai arsip toko
</div>

<script>
window.print();
</script>
</body>
</html>