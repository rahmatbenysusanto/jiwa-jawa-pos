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
        Schema::create('menu_recipe_material', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
            $table->integer('variant_id')->nullable();
            $table->integer('addon_id')->nullable();
            $table->integer('material_id');
            $table->decimal('qty', 9, 2)->default(0);
            $table->string('unit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_recipe_material');
    }
};
