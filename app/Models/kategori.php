<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    // Optionally, you can specify the table name if it's different from the model's name in plural form
    protected $table = 'kategori';

    // Guarded attributes to prevent mass assignment
    protected $guarded = ['kategori_id'];

    // Optionally, you can specify if the model timestamps should be managed automatically
    public $timestamps = false;

    // Optionally, you can define the primary key if it's different from 'id'
    protected $primaryKey = 'kategori_id';

    // Fillable attributes if you're using mass assignment
    protected $fillable = ['nama'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
