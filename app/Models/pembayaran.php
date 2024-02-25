<?php

// app/Models/Pembayaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $primaryKey = 'pembayaran_id';
    public $timestamps = false;
    protected $fillable = [
        'waktu_bayar',
        'total',
        'metode',
        'transaksi_id',
        'no_rek',
        // Add other fillable fields here
    ];

    // Define the relationship with the Transaksi model
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
    }
}
