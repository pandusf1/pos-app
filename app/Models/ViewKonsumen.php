<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewKonsumen extends Model
{
    protected $table = 'konsumen';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = []; 
}