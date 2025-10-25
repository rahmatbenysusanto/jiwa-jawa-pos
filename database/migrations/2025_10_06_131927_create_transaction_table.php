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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->string('invoice_number');
            $table->integer('order_number');
            $table->integer('qty');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total', 12, 2);
            $table->enum('transaction_status', ['normal', 'canceled'])->default('normal');
            $table->integer('payment_method_id');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->enum('transaction_type', ['sales', 'return', 'void'])->default('sales');
            $table->text('note')->nullable();
            $table->timestamp('transaction_date');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
