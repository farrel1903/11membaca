<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'pegawai';

    // Tentukan primary key
    protected $primaryKey = 'nip';

    // Menentukan apakah primary key adalah string
    protected $keyType = 'int';

    // Nonaktifkan timestamps jika Anda tidak ingin menggunakan created_at dan updated_at
    public $timestamps = true;

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'id_user',
        'nama',
        'jenis_kelamin',
        'no_telepon',
    ];

    // Definisikan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
