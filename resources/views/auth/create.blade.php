@extends('layout')
@section('content')
<div class="container">
 <h3>Tambah Suppllier</h3>
 <form method="POST" action="{{ route('supplier.store') }}">
 @csrf
 <div class="mb-2">
 <label>Kode Suppllier</label>
 <input type="text" name="kd_sup" class="form-control" required>
 </div>
 <div class="mb-2">
 <label>Nama</label>
 <input type="text" name="nm_sup" class="form-control" required>
 </div>
 <div class="mb-2">
 <label>Alamat</label>
 <input type="text" name="alamat" class="form-control">
 </div>
 <div class="mb-2">
 <label>Kota</label>
 <input type="text" name="kota" class="form-control">
 </div>
 <div class="mb-2">
 <label>Kode Pos</label>
 <input type="text" name="kd_pos" class="form-control">
 </div>
 <div class="mb-2">
 <label>Phone</label>
 <input type="text" name="phone" class="form-control">
 </div>
 <div class="mb-2">
 <label>Email</label>
 <input type="email" name="email" class="form-control">
 </div>
 <button class="btn btn-success">Simpan</button>
 <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
 </form>
</div>
@endsection