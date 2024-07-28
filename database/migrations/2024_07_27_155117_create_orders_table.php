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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('status')->default('pending');
            $table->unsignedInteger('user_id')->on('id')->reference('users')->nullable();
            $table->unsignedInteger('billpayer_id')->on('id')->reference('addresses')->nullable();
            $table->unsignedInteger('shipping_address_id')->on('id')->reference('addresses')->nullable();
            $table->unsignedInteger('order_item_id')->on('id')->reference('order_items')->nullable();
            $table->double('amount', 9, 2)->nullable();
            $table->string('total', 9, 2)->nullable();
            $table->text('note')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('billpayer_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table->foreign('shipping_address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table->foreign('order_item_id')
                ->references('id')
                ->on('order_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
