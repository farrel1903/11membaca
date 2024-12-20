<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika berbeda dari nama model dalam bentuk jamak
    protected $table = 'buku';

    // Menentukan kolom mana yang bisa diisi secara massal
    protected $fillable = [
        'id_buku_induk', 'id_rak', 'judul', 'kategori_id', 'ISBN', 'Penulis', 'Penerbit', 'tahun_terbit', 'sinopsis', 'stok', 'jumlah_buku', 'status', 'sampul', 'ebook',
    ];

    public function bukuAnak()
    {
        return $this->hasMany(BukuAnak::class, 'id_buku_induk', 'id_buku_induk');
    }

    // Menentukan primary key jika bukan 'id'
    protected $primaryKey = 'id_buku_induk';

    // Menentukan apakah primary key adalah auto-increment
    public $incrementing = false;

    // Menentukan tipe data primary key jika bukan integer
    protected $keyType = 'string';

    // Mendefinisikan relasi dengan model Rak
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak');
    }

    // Mendefinisikan relasi dengan model Categories
    public function kategori()
    {
        return $this->belongsTo(Categories::class, 'kategori_id', 'kategori_id'); // Menghubungkan ke kategori
    }

    public function riwayat() 
    {
        return $this->hasMany(Historionline::class, 'id_buku_induk');
    }
}
