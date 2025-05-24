<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // FK ke tenants.id
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Contoh: 10 digit total, 2 digit di belakang koma (99999999.99)
            $table->string('image')->nullable(); // Path ke gambar menu
            $table->integer('stock')->nullable(); // null atau -1 bisa berarti tak terbatas
            $table->boolean('is_available')->default(true);
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};