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
        Schema::create('material', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('sku');
            $table->integer('unit_id');
            $table->integer('base_unit_id');
            $table->decimal('conversion_value', 10, 2)->default(0);
            $table->decimal('min_stock', 9, 2)->default(0);
            $table->decimal('price', 9, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
