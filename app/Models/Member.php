<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';
    protected $primaryKey = 'nis_nik'; // Primary key untuk tabel member

    protected $fillable = [
        'nis_nik',
        'id_user',
        'nama',
        'jenis_kelamin',
        'no_telepon',
        'status',
        'asal_sekolah',
        'tingkatan', 
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
