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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku');
            $table->string('nama');
            $table->unsignedBigInteger('kategori_id'); // Foreign key
            $table->string('ISBN');
            $table->string('Penulis');
            $table->string('Penerbit');
            $table->text('Deskripsi')->nullable();
            $table->integer('stok');
            $table->string('foto')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
