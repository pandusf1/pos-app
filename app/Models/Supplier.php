<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model
{
 protected $table = 'supplier';
 protected $primaryKey = 'kd_sup';
 public $timestamps = false;
 protected $keyType = 'string';
 protected $fillable = [
 'kd_sup', 'nm_sup', 'alamat', 'kota','kd_pos', 'phone', 'email'
 ];
}