<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // ID auto increment
            $table->string('id_pinjam'); // ID peminjaman (berikan tipe yang sesuai dengan database)
            $table->integer('rating'); // Rating dari 1 sampai 5
            $table->string('judul_buku'); // Judul buku yang diberikan rating
            $table->timestamps(); // Untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
