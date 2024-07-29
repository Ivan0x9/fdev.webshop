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
            $table->unsignedBigInteger('billpayer_id')->on('id')->reference('addresses')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->on('id')->reference('addresses')->nullable();
            $table->double('amount', 9, 2)->nullable();
            $table->string('total', 9, 2)->nullable();
            $table->text('note')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('billpayer_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table->foreign('shipping_address_id')
                ->references('id')
                ->on('addresses')
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
