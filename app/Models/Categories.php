<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    // Nama tabel, jika tidak mengikuti konvensi Laravel
    protected $table = 'categories';
    protected $primaryKey = 'kategori_id';

    // Kolom-kolom yang bisa diisi
    protected $fillable = ['kategori', 'waktu_peminjaman', 'harga_keterlambatan'];

    // Relasi ke model Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'kategori_id'); // Foreign key dan primary key disesuaikan
    }
}
