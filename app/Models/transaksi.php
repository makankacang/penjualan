<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'transaksi_id';

    protected $guarded = ['id'];
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    // Define the relationship with the Pembayaran model
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'transaksi_id', 'transaksi_id');
    }
}
