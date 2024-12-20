<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table name
    protected $table = 'pengguna';

    // Primary key
    protected $primaryKey = 'UserID';

    // Fillable fields
    protected $fillable = [
        'nama_lengkap', 
        'username', 
        'password', 
        'jenis_kelamin', 
        'nomor_telepon',
        'role_as',
    ];

    // Hide password attribute
    protected $hidden = [
        'password', 'remember_token',
    ];


    // Cast attributes
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Set password attribute with hashing
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Specify the authentication guard's username field
    public function getAuthUsername()
    {
        return 'username';
    }
}
