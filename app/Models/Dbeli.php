<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dbeli extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'dbeli';

    protected $fillable = [
        'no_beli',
        'kd_brg',
        'harga_beli',
        'jml_beli',
        'subtotal',
    ];


    // 🔗 RELASI KE HEADER BELI
    public function beli()
    {
        return $this->belongsTo(Beli::class, 'no_beli', 'no_beli');
    }

    // 🔗 RELASI KE BARANG
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_brg', 'kd_brg');
    }
}