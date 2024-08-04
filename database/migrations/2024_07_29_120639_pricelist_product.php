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
        Schema::create('pricelist_product', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('pricelist_id');
            $table->string('product_sku');
            $table->double('price', 9, 2);
            
            $table->foreign('pricelist_id')
                ->references('id')
                ->on('pricelists')
                ->onDelete('cascade');

            $table->foreign('product_sku')
                ->references('sku')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricelist_product');
    }
};
