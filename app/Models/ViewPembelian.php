<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ViewPembelian extends Model
{
protected $table = 'view_beli_lgkp';
public $timestamps = false;
// Karena ini VIEW tidak ada primary key
protected $primaryKey = null;
public $incrementing = false;
}