<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanOffline extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'peminjaman_offline';

    // Tentukan kolom yang dapat diisi massal
    protected $fillable = [
        'id_buku_induk',
        'id_user',
        'tanggal_pinjam',
        'tanggal_kembali',
        // Tambahkan kolom lain yang relevan
    ];

    // Jika ada relasi, definisikan relasi di sini
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku_induk');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_user');
    }
}
