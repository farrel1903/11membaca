<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $fillable = [
        'kode_buku', 'nama', 'kategori_id', 'ISBN', 'Penulis', 'Penerbit', 'Deskripsi', 'stok', 'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(Categories::class, 'kategori_id');
    }
}