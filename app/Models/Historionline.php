<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historionline extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'historionline';

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

    // Jika id_pinjam adalah primary key dan tidak auto-increment
    protected $primaryKey = 'id_pinjam';
    public $incrementing = false; // Jika id_pinjam tidak menggunakan auto-increment
    protected $keyType = 'string'; // Tipe data primary key
    protected static function boot()
    {
        parent::boot();

        // Menambahkan logika auto-increment pada kolom id_pinjam
        static::creating(function ($model) {
            $latestEntry = self::orderBy('id_pinjam', 'desc')->first();

            if (!$latestEntry) {
                // Jika belum ada data, mulai dari PNJ001
                $newId = 'PNJ001';
            } else {
                // Ambil angka terakhir dari id_pinjam
                $lastIdNumber = (int) substr($latestEntry->id_pinjam, 3);
                // Tambahkan 1
                $newId = 'PNJ' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
            }

            // Tetapkan id_pinjam baru ke model
            $model->id_pinjam = $newId;
        });
    }
}
