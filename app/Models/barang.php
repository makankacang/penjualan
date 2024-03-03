<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Optionally, you can specify the table name if it's different from the model's name in plural form
    protected $table = 'barang';

    // Guarded attributes to prevent mass assignment
    protected $guarded = ['id'];

    // Optionally, you can specify if the model timestamps should be managed automatically
    public $timestamps = false;

    // Optionally, you can define the primary key if it's different from 'id'
    protected $primaryKey = 'id';

    // Fillable attributes if you're using mass assignment
    protected $fillable = ['kode_barang', 'nama_barang', 'harga', 'stok', 'supplier_id', 'kategori_id', 'deskripsi', 'image'];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
