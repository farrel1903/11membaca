<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'transaksi_detail';

    // Menentukan primary key
    protected $primaryKey = ['id_transaksi', 'id_buku_anak'];
    public $incrementing = false; // Menyatakan bahwa kunci utama bukan integer yang diinkremen
    protected $keyType = 'string';

    // Mengizinkan mass assignment pada kolom-kolom yang diizinkan
    protected $fillable = [
        'id_transaksi',
        'id_buku_anak',
        'judul',
        'denda',
        'tanggal_pengembalian_buku',
        'id_jenis_denda',
        'status',
    ];

    // Menentukan relasi dengan tabel Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Menentukan relasi dengan tabel BukuAnak
    public function bukuAnak()
    {
        return $this->belongsTo(BukuAnak::class, 'id_buku_anak');
    }    

    // Menentukan relasi dengan tabel JenisDenda
    public function jenisDenda()
    {
        return $this->belongsTo(JenisDenda::class, 'id_jenis_denda');
    }
}
