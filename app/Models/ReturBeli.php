<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturBeli extends Model
{
    protected $table = 'retur_beli';
    protected $primaryKey = 'no_retur_beli';

    public $incrementing = true;   // ✅ HARUS TRUE
    protected $keyType = 'int';    // ✅ HARUS INT

    protected $fillable = [
        'no_beli',
        'tgl_retur',
        'total_retur'
    ];

    public $timestamps = true;

    public function detail()
    {
        return $this->hasMany(DReturBeli::class, 'no_retur_beli');
    }

    public function beli()
    {
        return $this->belongsTo(beli::class, 'no_beli', 'no_beli');
    }

}
