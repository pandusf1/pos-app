<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ViewSupplier extends Model
{
protected $table = 'supplier';
public $timestamps = false;
// Karena ini VIEW tidak ada primary key
protected $primaryKey = null;
public $incrementing = false;
}