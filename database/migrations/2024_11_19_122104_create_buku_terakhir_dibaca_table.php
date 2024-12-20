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
        Schema::create('buku_terakhir_dibaca', function (Blueprint $table) {
            $table->id('id_buku_terakhir_dibaca');
            $table->string('id_user');
            $table->string('id_buku');
            $table->integer('halaman_terakhir');
            $table->timestamps();
    
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku_induk')->on('buku')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_terakhir_dibaca');
    }
};
