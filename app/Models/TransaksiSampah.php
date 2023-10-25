<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSampah extends Model
{
    use HasFactory;
    protected $table = 'transaksi_sampah';
    protected $fillable = [
        'jenis_sampah_id', 
        'jumlah_kilogram', 
        'total_harga', 
        'waktu_penerimaan'
    ];

    public function jenis_sampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id', 'id');
    }
}
