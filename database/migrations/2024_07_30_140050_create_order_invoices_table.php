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
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('status');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('email');
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->longText('order_items')->nullable();
            $table->longText('payment_details')->nullable();
            $table->string('total', 9, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_invoices');
    }
};
