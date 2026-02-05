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
        Schema::create('data_polis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polis');
            $table->string('jenis_penanggungan');
            $table->unsignedTinyInteger('jangka_waktu');
            $table->string('okupasi');
            $table->unsignedBigInteger('harga_bangunan');
            $table->string('konstruksi');
            $table->string('alamat');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kabupaten');
            $table->string('daerah');
            $table->boolean('gempa')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_polis');
    }
};
