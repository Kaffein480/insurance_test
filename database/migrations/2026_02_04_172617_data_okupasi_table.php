<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('data_okupasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_okupasi');
            $table->decimal('premi', 8, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_okupasi');
    }
};
