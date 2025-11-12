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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->integer('category_id');
            $table->string('sku');
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('hpp', 12, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('is_combo', ['yes', 'no'])->default('no');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
