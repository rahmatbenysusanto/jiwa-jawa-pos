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
        Schema::create('discount', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->integer('menu_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->enum('scope', ['transaction', 'product'])->default('transaction');
            $table->enum('type', ['percentage', 'nominal'])->default('nominal');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('value', 10, 2)->default(0);
            $table->decimal('max_value', 10, 2)->default(0);
            $table->decimal('min_transaction_amount', 10, 2)->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('usage_limit')->default(0);
            $table->integer('used_count')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
