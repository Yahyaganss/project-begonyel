<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori'
    ];

    // hubungkan tabel kategoris ke tabel produks
    public function produks() {
        return $this->hasMany(Product::class,'kategori_id','id');
    }

}
