<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'ukuran_id',
        'kemanisan_id',
        'jumlah',
        'harga_saat_transaksi',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }

    public function kemanisan()
    {
        return $this->belongsTo(TingkatKemanisan::class, 'kemanisan_id');
    }

    public function topping()
    {
        return $this->belongsToMany(Topping::class, 'detail_transaksi_topping')
                    ->withPivot('harga_topping_saat_transaksi')
                    ->withTimestamps();
    }
}
