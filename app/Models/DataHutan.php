<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataHutan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provinsi',
        'pulau',
        'luas_hektar',
        'jenis_vegetasi',
        'status_konservasi',
        'geojson',
        'latitude',
        'longitude',
        'tahun_data',
        'updated_by',
    ];

    protected $casts = [
        'jenis_vegetasi' => 'array',
        'luas_hektar' => 'decimal:2',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
