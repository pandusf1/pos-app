<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jual extends Model
{
    protected $table = 'jual';
    protected $primaryKey = 'no_jual';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_jual',
        'tgl_jual',
        'kd_kons',
        'total',
    ];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'kd_kons');
    }

    public function detail()
    {
        return $this->hasMany(Djual::class, 'no_jual', 'no_jual');
    }
}