<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewBarang extends Model
{
    protected $table = 'barang';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = []; 
}