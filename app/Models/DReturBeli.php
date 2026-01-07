<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DReturBeli extends Model
{
    protected $table = 'dretur_beli';

    protected $fillable = [
        'no_retur_beli',
        'kd_brg',
        'qty_retur',
        'harga_beli',
        'subtotal'
    ];

    public function retur()
    {
        return $this->belongsTo(ReturBeli::class, 'no_retur_beli');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_brg', 'kd_brg');
    }

}
