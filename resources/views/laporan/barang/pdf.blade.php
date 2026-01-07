<h3>Laporan Barang</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Stok Min</th>
            <th>Expired</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->kd_brg }}</td>
            <td>{{ $d->nm_brg }}</td>
            <td>{{ $d->satuan }}</td>
            <td>{{ number_format($d->harga_beli) }}</td>
            <td>{{ number_format($d->harga_jual) }}</td>
            <td>{{ $d->stok }}</td>
            <td>{{ $d->stok_min }}</td>
            <td>{{ $d->expired ? date('d-m-Y', strtotime($d->expired)) : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>