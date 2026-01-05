<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'invoice_number',
        'biaya_total',
        'biaya_per_hektar',
        'status_pembayaran',
        'payment_gateway',
        'payment_id_external',
        'invoice_pdf',
        'sertifikat_pdf',
        'paid_at',
    ];

    protected $casts = [
        'biaya_total' => 'decimal:2',
        'biaya_per_hektar' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
