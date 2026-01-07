@extends('layout')
@section('content')
<div class="container">
 <h3>Data Supplier</h3>
 <a href="{{ route('supplier.create') }}" class="btn btn-primary nd-3">Tambah Supplier</a>
 <table class="table table-bordered table-sm">
 <thead>
 <tr>
 <th>Kode</th>
 <th>Nama</th>
 <th>Alamat</th>
 <th>Kota</th>
 <th>Phone</th>
 <th>Email</th>
 <th width="120">Aksi</th>
 </tr>
 </thead>
 <tbody>
 @foreach($data as $k)
 <tr>
 <td>{{ $k->kd_sup }}</td>
 <td>{{ $k->nm_sup }}</td>
 <td>{{ $k->alamat }}</td>
 <td>{{ $k->kota }}</td>
 <td>{{ $k->phone }}</td>
 <td>{{ $k->email }}</td>
 <td>
 <a href="{{ route('supplier.edit', $k->kd_sup) }}" class="btn btn-warning btn-sm">Edit<a>
 <form action="{{ route('supplier.destroy', $k->kd_sup) }}" method="POST" style="display:inline;">
 @csrf @method('DELETE')
 <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus supplier?')">Hapus</button>
 </form>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
</div>
@endsection