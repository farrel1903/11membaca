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
        Schema::create('bukuanak', function (Blueprint $table) {
            $table->string('id_buku_anak')->primary();
            $table->string('id_buku_induk');
            $table->string('judul');
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->timestamps();

            // Foreign key constraint referencing the 'buku' table
            $table->foreign('id_buku_induk')->references('id_buku_induk')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukuanak');
    }
};
