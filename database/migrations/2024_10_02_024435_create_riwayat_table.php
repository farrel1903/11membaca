<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->string('id_pinjam')->primary();
            $table->string('id_user'); // ID user yang meminjam
            $table->string('id_buku_induk'); // ID buku yang dipinjam
            $table->string('judul'); // Judul buku
            $table->string('kategori'); // Kategori buku
            $table->string('isbn'); // ISBN buku
            $table->date('tanggal_peminjaman'); // Tanggal pinjam
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat');
    }
}
