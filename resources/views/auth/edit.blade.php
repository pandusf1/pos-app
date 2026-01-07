@extends('layout')
@section('content')
<div class="container">
 <h3>Edit Supplier</h3>
 <form method="POST" action="{{ route('supplier.update', $s->kd_sup) }}">
 @csrf
 @method('PUT')
 <div class="mb-2">
 <label>Kode Supplier</label>
 <input type="text" class="form-control" value="{{ $s->kd_sup }}" disabled>
 </div>
 <div class="mb-2">
 <label>Nama</label>
 <input type="text" name="nm_sup" class="form-control" value="{{ $s->nm_sup }}" required>
 </div>
 <div class="mb-2">
 <label>Alamat</label>
 <input type="text" name="alamat" class="form-control" value="{{ $s->alamat }}">
 </div>
 <div class="mb-2">
 <label>Kota</label>
 <input type="text" name="kota" class="form-control" value="{{ $s->kota }}">
 </div>
 <div class="mb-2">
 <label>Kode Pos</label>
 <input type="text" name="kd_pos" class="form-control" value="{{ $s->kd_pos }}">
 </div>
 <div class="mb-2">
 <label>Phone</label>
 <input type="text" name="phone" class="form-control" value="{{ $s->phone }}">
 </div>
 <div class="mb-2">
 <label>Email</label>
 <input type="email" name="email" class="form-control" value="{{ $s->email }}">
 </div>
 <button class="btn btn-primary">Update</button>
 <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
 </form>
</div>
@endsection