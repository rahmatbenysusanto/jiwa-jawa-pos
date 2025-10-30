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
        Schema::create('material_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->integer('material_id');
            $table->integer('transaction_id')->nullable();
            $table->integer('transaction_detail_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('variant_detail_id')->nullable();
            $table->integer('addon_detail_id')->nullable();
            $table->decimal('qty')->default(0);
            $table->string('type')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_usage');
    }
};
