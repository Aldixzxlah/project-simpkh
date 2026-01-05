<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nomor_laporan',
        'judul',
        'keperluan',
        'lokasi_polygon',
        'latitude',
        'longitude',
        'luas_dimohon',
        'alasan',
        'dampak_lingkungan',
        'dokumen',
        'status',
        'catatan_admin',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'lokasi_polygon' => 'array',
        'dokumen' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'luas_dimohon' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
