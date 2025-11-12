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
        Schema::create('menu_variant_option', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_variant_id');
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->decimal('price_delta', 12, 2)->default(0);
            $table->decimal('hpp', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_variant_option');
    }
};
