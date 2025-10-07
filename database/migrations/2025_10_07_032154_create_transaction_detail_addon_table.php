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
        Schema::create('transaction_detail_addon', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_detail_id');
            $table->integer('addon_variant_id');
            $table->string('addon_name');
            $table->integer('addon_price')->default(0);
            $table->integer('qty');
            $table->integer('total_price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail_addon');
    }
};
