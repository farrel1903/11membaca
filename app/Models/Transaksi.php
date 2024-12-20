<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'transaksi';

    // Primary key untuk tabel ini
    protected $primaryKey = 'id_transaksi';

    // Tipe primary key
    public $incrementing = false;
    protected $keyType = 'string';

    // Daftar atribut yang dapat diisi secara massal
    protected $fillable = [
        'id_transaksi',
        'nis_nik',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];

    // Mengatur relasi dengan model Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'nis_nik', 'nis_nik');
    }

    // Relasi dengan transaksi_detail
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id_transaksi');
    }    

    // Mengatur relasi dengan model Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku'); // Sesuaikan dengan kolom yang ada
    }
}
