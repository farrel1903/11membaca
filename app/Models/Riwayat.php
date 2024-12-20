<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat'; // Menentukan nama tabel yang benar

    // Jika Anda memiliki kolom yang tidak bisa diisi massal
    protected $guarded = [];

    protected $fillable = [
        'id_pinjam', // Ubah nama menjadi id_pinjam
        'id_user',
        'id_buku_induk',
        'judul',
        'kategori',
        'isbn',
        'tanggal_peminjaman',
    ];

    // Method untuk membuat id_pinjam
    public static function generateId()
    {
        $lastId = self::orderBy('id_pinjam', 'desc')->pluck('id_pinjam')->first(); // Ubah dari id_riwayat ke id_pinjam
        $number = 1; // Default ke 1 jika tidak ada data

        if ($lastId) {
            $number = (int) substr($lastId, 3) + 1; // Ambil angka terakhir dan tambahkan 1
        }

        return 'PNJ' . str_pad($number, 3, '0', STR_PAD_LEFT); // Format "PNJ001"
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku_induk');
    }
}
