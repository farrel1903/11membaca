<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';
    protected $primaryKey = 'id_rak'; // Menyatakan bahwa id_rak adalah kunci utama
    public $incrementing = false; // Jika id_rak bukan auto increment
    protected $keyType = 'string'; // Jika id_rak bertipe string
    protected $fillable = ['id_rak'];

    public $timestamps = true; 
}