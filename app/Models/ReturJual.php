<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturJual extends Model
{
    protected $table = 'retur_jual';
    protected $primaryKey = 'no_retur_jual';

    public $incrementing = true; // ✅ AUTO INCREMENT
    protected $keyType = 'int';

    protected $fillable = [
        'no_jual',
        'tgl_retur',
        'total_retur'
    ];

    public function detail()
    {
        return $this->hasMany(DReturJual::class, 'no_retur_jual');
    }
}
