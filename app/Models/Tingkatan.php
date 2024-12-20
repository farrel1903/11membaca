<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'tingkatan';

    // Tentukan primary key
    protected $primaryKey = 'id_tingkatan';

    // Menentukan apakah primary key adalah string
    protected $keyType = 'string';

    // Nonaktifkan timestamps jika Anda tidak ingin menggunakan created_at dan updated_at
    public $timestamps = true;

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'tingkatan',
        'jumlah_pinjam_ebook',
    ];

    // Tambahkan relasi jika diperlukan
    // Contoh:
    // public function pegawai()
    // {
    //     return $this->hasMany(Pegawai::class, 'id_tingkatan', 'id_tingkatan');
    // }
}
