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
        Schema::create('catalog_category_taxonomy', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->morphs('subcategory');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('catalog_categories')
                ->onDelete('cascade');

            $table->primary(['category_id', 'subcategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_category_taxonomy');
    }
};
