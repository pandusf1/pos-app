<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beli extends Model
{
    use HasFactory;

    // ⛔ tabel beli tidak pakai timestamps
    public $timestamps = false;

    protected $table = 'beli';

    // ⛔ primary key pakai string
    protected $primaryKey = 'no_beli';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_beli',
        'kd_sup',
        'tgl_beli',
        'total',
        'jenis',
    ];

    /* ================= RELATIONS ================= */

    // Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kd_sup', 'kd_sup');
    }

    // Detail pembelian
    public function detail()
    {
        return $this->hasMany(Dbeli::class, 'no_beli', 'no_beli');
    }
}
