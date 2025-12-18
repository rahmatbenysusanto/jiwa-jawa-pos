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
        Schema::create('kas_rekonsiliasi', function (Blueprint $table) {
            $table->id();
            $table->integer('modal_awal')->default(0);
            $table->integer('modal_akhir')->default(0);
            $table->integer('cash')->default(0);
            $table->integer('qris')->default(0);
            $table->integer('debit')->default(0);
            $table->integer('laba_kotor')->default(0);
            $table->integer('laba_bersih')->default(0);
            $table->timestamp('tanggal');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_rekonsiliasi');
    }
};
