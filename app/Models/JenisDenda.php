<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDenda extends Model
{
    use HasFactory;

    protected $table = 'jenis_denda'; // Nama tabel di database
    protected $primaryKey = 'id_jenis_denda'; // Menentukan primary key
    public $incrementing = false; // Menentukan bahwa primary key tidak menggunakan auto-increment
    protected $keyType = 'string'; // Tipe primary key

    protected $fillable = [
        'jenis_denda', // Daftar kolom yang dapat diisi
    ];

    // Jika Anda ingin menambahkan relasi atau fungsi lain, bisa ditambahkan di sini
}
