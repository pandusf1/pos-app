<h3>Laporan Data Supplier</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
<thead>
    <tr>
        <th>Kode Sup</th>
        <th>Nama Supplier</th>
        <th>Alamat</th>
        <th>Kota</th>
        <th>Kode Pos</th>
        <th>Telepon</th>
        <th>Email</th>
    </tr>
</thead>
<tbody>
    @foreach($data as $d)
    <tr>
        <td>{{ $d->kd_sup }}</td>
        <td>{{ $d->nm_sup }}</td>
        <td>{{ $d->alamat }}</td>
        <td>{{ $d->kota }}</td>
        <td>{{ $d->kd_pos }}</td>
        <td>{{ $d->phone }}</td>
        <td>{{ $d->email }}</td>
    </tr>
    @endforeach
</tbody>
</table>