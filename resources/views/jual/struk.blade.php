<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Struk Penjualan</title>
<style>
body{
    font-family: monospace;
    width: 220px; /* 58mm */
    margin: 0 auto;
    font-size: 12px;
    line-height: 1.4;
}

.center{text-align:center;}
.right{text-align:right;}

.line{
    border-top: 1px dashed #000;
    margin: 6px 0;
}

.item-row{
    display:flex;
    justify-content:space-between;
}

.small{font-size:11px;}
.bold{font-weight:bold;}
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

<!-- INFO TRANSAKSI -->
<div>No : {{ $jual->no_jual }}</div>
<div>Tgl: {{ $jual->tgl_jual }}</div>
<div>Cust: {{ $jual->konsumen->nm_kons }}</div>

<div class="line"></div>

<!-- DETAIL BARANG -->
@php $total = 0; @endphp
@foreach($jual->detail as $d)
@php
    $sub = $d->jml_jual * $d->harga_jual;
    $total += $sub;
@endphp

<div>{{ $d->barang->nm_brg }}</div>
<div class="item-row">
    <span>{{ $d->jml_jual }} x {{ number_format($d->harga_jual) }}</span>
    <span>{{ number_format($sub) }}</span>
</div>
@endforeach

<div class="line"></div>

<!-- TOTAL -->
<div class="item-row bold">
    <span>TOTAL</span>
    <span>Rp {{ number_format($total) }}</span>
</div>

<div class="line"></div>

<!-- FOOTER -->
<div class="center small">
Terima kasih atas<br>
kunjungan Anda 🙏<br>
</div>

<script>
window.print();
</script>
</body>
</html>
