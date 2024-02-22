<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $guarded = ['supplier_id'];
    public $timestamps = false;

    protected $primaryKey = 'supplier_id';

    protected $fillable = ['nama', 'telp', 'alamat'];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
