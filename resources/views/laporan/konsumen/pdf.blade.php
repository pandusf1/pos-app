<h3>Laporan Konsumen</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>Kode Konsumen</th>
            <th>Nama Konsumen</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Kode Pos</th>
            <th>No Telp</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->kd_kons }}</td>
                <td>{{ $d->nm_kons }}</td>
                <td>{{ $d->alm_kons }}</td>
                <td>{{ $d->kota_kons }}</td>
                <td>{{ $d->kd_pos }}</td>
                <td>{{ $d->phone }}</td>
                <td>{{ $d->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>