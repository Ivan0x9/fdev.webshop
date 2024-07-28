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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_published')->default(false);
            $table->string('sku');
            $table->string('name');
            $table->string('title')->nullable();
            $table->unsignedInteger('product_variety_id')->reference('id')->on('product_variety');
            $table->text('description')->nullable();
            $table->string('status')->default('draft');
            $table->double('price', 9, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
