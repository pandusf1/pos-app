<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DReturJual extends Model
{
    protected $table = 'dretur_jual';

    protected $fillable = [
        'no_retur_jual',
        'kd_brg',
        'qty_retur',
        'harga_jual',
        'subtotal'
    ];

    public function retur()
    {
        return $this->belongsTo(ReturJual::class, 'no_retur_jual');
    }
}
