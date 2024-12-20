<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';
    public $incrementing = false; // Menonaktifkan auto-increment

    protected $fillable = [
        'id_user',
        'name',
        'email',
        'password',
        'role_as',
        'status', // Tambahkan ini untuk memungkinkan status diisi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        // Menambahkan event creating untuk mengatur id_user
        static::creating(function ($user) {
            $user->id_user = self::generateIdUser();
        });
    }

    // Fungsi untuk menghasilkan id_user dengan format "USR01"
    public static function generateIdUser()
    {
        $latestUser = self::orderBy('id_user', 'desc')->first();
        $lastNumber = 0;

        if ($latestUser) {
            // Mendapatkan angka dari ID terakhir
            $lastNumber = (int)substr($latestUser->id_user, 3);
        }

        // Membuat angka baru dengan padding 2 digit
        $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        return 'USR' . $newNumber;
    }

    public function member ()
    {
        return $this->hasOne(Member::class, 'id_user', 'id_user');
    }
}
