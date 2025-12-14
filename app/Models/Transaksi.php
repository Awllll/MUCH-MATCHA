<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'nama_pembeli',
        'total_harga',
        'metode_pembayaran', // Ini string, bukan foreign key
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMetodePembayaranNamaAttribute()
    {
        return ucfirst($this->metode_pembayaran);
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id');
    }

    // Scope untuk transaksi hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('created_at', today());
    }
}
