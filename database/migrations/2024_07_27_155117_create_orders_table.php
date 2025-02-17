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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('billpayer_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->longText('payment_details')->nullable();
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
                ->onDelete('set null');

            $table->foreign('shipping_address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('set null');
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
