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
        Schema::create('catalog_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('taxonomy_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->nestedSet();
            $table->timestamps();

            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('catalog_taxonomies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_categories');
    }
};
