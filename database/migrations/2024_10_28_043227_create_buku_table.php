<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->string('id_buku_induk')->primary();
            $table->string('id_rak');
            $table->string('judul');
            $table->unsignedBigInteger('kategori_id'); // Foreign key
            $table->string('ISBN');
            $table->string('Penulis');
            $table->string('Penerbit');
            $table->year('tahun_terbit');
            $table->text('sinopsis')->nullable();
            $table->integer('jumlah_halaman');
            $table->integer('stok');
            $table->integer('jumlah_buku');
            $table->string('sampul')->nullable();
            $table->string('ebook')->nullable();
            $table->unsignedBigInteger('harga');
            $table->enum('status', ['full', 'offline', 'online']); // Kolom status
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
