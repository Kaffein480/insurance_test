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
        Schema::create('data_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice');
            $table->tinyInteger("jangka_waktu");
            $table->decimal('premi_dasar', 18, 4);
            $table->decimal('total_biaya', 18, 4);
            $table->string('status')->nullable()->default(null);
            $table->timestamp('approved_at')->nullable()->default(null);
            $table->unsignedBigInteger('polis_id');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_invoice');
    }
};
