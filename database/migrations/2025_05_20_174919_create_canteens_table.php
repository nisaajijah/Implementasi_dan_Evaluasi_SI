<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canteens', function (Blueprint $table) {
            $table->id(); // BigIncrements, Primary Key
            $table->string('name');
            $table->text('location_description')->nullable();
            $table->string('operating_hours')->nullable();
            $table->string('image')->nullable(); // Path ke gambar
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteens');
    }
};