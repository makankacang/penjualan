<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_order',
        'pembayaran_id',
        'transaksi_id',
        // Add other fillable attributes here
    ];

    /**
     * Get the transaksi associated with the order.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Get the pembayaran associated with the order.
     */
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
