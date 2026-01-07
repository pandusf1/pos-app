<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Barang extends Model
{
 protected $table = 'barang';
 protected $primaryKey = 'kd_brg';
 public $incrementing = false;
 protected $keyType = 'string';
 protected $fillable = [
 'kd_brg','nm_brg','satuan','harga_jual','harga_beli',
 'stok','stok_min','expired','gambar'
 ];
// ✅ Tambahkan ini untuk mematikan created_at & updated_at
 public $timestamps = false;
}
