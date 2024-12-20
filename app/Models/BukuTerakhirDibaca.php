<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTerakhirDibaca extends Model
{
    use HasFactory;

    protected $table = 'buku_terakhir_dibaca';
    protected $primaryKey = 'id_buku_terakhir_dibaca';
    protected $fillable = ['id_user', 'id_buku', 'halaman_terakhir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
