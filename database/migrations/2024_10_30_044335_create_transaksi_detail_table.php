<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_detail', function (Blueprint $table) {
            // Menggunakan id_transaksi sebagai foreign key yang merujuk ke tabel transaksi
            $table->string('id_transaksi'); // Kolom id_transaksi
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');

            // Kolom untuk buku
            $table->string('id_buku_anak');
            $table->foreign('id_buku_anak')->references('id_buku_anak')->on('bukuanak')->onDelete('cascade');

            // Kolom untuk judul dan durasi
            $table->string('judul'); // Menyimpan judul buku
            $table->enum('durasi', ['3', '5', '7']); // Durasi peminjaman

            // Kolom untuk denda (optional)
            $table->integer('denda')->nullable();
            $table->date('tanggal_pengembalian_buku')->nullable();
            $table->string('id_jenis_denda')->nullable();
            $table->foreign('id_jenis_denda')->references('id_jenis_denda')->on('jenis_denda')->onDelete('cascade');

            // Kolom status
            $table->enum('status', ['Belum Mengembalikan', 'Sudah Mengembalikan']);
            $table->timestamps();

            // Mengatur id_transaksi dan id_buku_anak sebagai composite primary key
            $table->primary(['id_transaksi', 'id_buku_anak']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};


