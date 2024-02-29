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
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_order',
        'pembayaran_id',
        'transaksi_id',
        'pelanggan_id',
        
        // Add other fillable attributes here
    ];

    /**
     * Get the transaksi associated with the order.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function transaksidetail()
    {
        return $this->hasMany(transaksidetail::class, 'transaksi_detail_id'); // Assuming 'transaksi_id' is the foreign key in the transaksiDetail table
    }
    /**
     * Get the pembayaran associated with the order.
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pembayaran_id'); // Assuming 'transaksi_id' is the foreign key in the pembayaran table
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
}
