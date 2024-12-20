<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historioffline extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'historioffline';

    // Jika Anda tidak menggunakan timestamps, pastikan ini sudah sesuai
    // public $timestamps = false;

    // Daftar atribut yang dapat diisi massal
    protected $fillable = [
        'id_pinjam',
        'id_user',
        'id_buku_induk',
        'judul',
        'kategori',
        'isbn',
        'tanggal_peminjaman',
        'tanggal_pengembalian', // Pastikan ini sesuai dengan nama kolom di tabel
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan model Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku_induk');
    }
}
