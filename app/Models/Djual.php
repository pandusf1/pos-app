<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DJual extends Model
{
    protected $table = 'djual';
    public $timestamps = false;

    // 🔥 TAMBAHKAN PRIMARY KEY ID
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'no_jual',
        'kd_brg',
        'subtotal',
        'harga_jual',
        'jml_jual',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_brg');
    }
}
