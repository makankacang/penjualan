<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Optionally, you can specify the table name if it's different from the model's name in plural form
    protected $table = 'pelanggan';
    protected $guarded = ['created_at', 'updated_at'];
    public $timestamps = false;

    // Optionally, you can define the primary key if it's different from 'id'
    protected $primaryKey = 'pelanggan_id';

    // Fillable attributes if you're using mass assignment
    protected $fillable = ['nama', 'jenis_kelamin', 'telp', 'alamat'];
    
}
