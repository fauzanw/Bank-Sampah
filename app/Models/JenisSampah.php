<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;
    protected $table = 'jenis_sampah';
    protected $fillable = ['nama', 'deskripsi', 'foto', 'harga_per_kilogram'];

    public function transaksi_sampah()
    {
        return $this->hasMany(TransaksiSampah::class, 'jenis_sampah_id', 'id');
    }
}
