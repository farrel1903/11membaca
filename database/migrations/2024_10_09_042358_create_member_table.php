<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->string('nis_nik')->primary(); // Primary key
            $table->string('id_user'); // Kolom untuk menghubungkan dengan tabel users
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('no_telepon');
            $table->string('foto')->nullable(); // Kolom untuk menyimpan path/nama file foto
            $table->enum('status', ['Full', 'General'])->nullable();
            $table->string('asal_sekolah')->default('umum'); // Kolom asal_sekolah dengan default 'umum'
            $table->enum('tingkatan', ['NonPro', 'Pro'])->default('NonPro'); // Kolom tingkatan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('member');
    }
}
