<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuAnak extends Model
{
    use HasFactory;

    protected $table = 'bukuanak';

    protected $primaryKey = 'id_buku_anak';

    public $incrementing = false; // Karena ID tidak auto-increment

    protected $fillable = [
        'id_buku_anak',
        'id_buku_induk',
        'judul',
        'status',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku_induk', 'id_buku_induk');
    }
}
