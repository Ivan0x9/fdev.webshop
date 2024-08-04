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
            $table->unsignedBigInteger('pricelist_id');
            $table->string('product_sku')->references('sku')->on('products');
            $table->double('price', 9, 2);
            
            $table->primary(['pricelist_id', 'product_sku']);
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
