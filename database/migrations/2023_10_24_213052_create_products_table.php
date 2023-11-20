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
            $table->string('name', 100)->unique();
            $table->string('description')->nullable();
            $table->integer('price');
            $table->string('status')->default('active');
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('product_type')->nullable();
            $table->$table->timestamps();

            $table->foreign('category')
                ->references('id')
                ->on('product_categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('product_type')
                ->references('id')
                ->on('product_types')
                ->nullOnDelete()
                ->cascadeOnUpdate();
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
