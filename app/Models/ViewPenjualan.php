<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ViewPenjualan extends Model
{
protected $table = 'view_jual_lgkp';
public $timestamps = false;
// Karena ini VIEW tidak ada primary key
protected $primaryKey = null;
public $incrementing = false;
}