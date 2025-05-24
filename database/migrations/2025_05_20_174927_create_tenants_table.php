<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK ke users.id
            $table->foreignId('canteen_id')->constrained('canteens')->onDelete('cascade'); // FK ke canteens.id
            $table->string('name'); // Nama kios/tenant
            $table->text('description')->nullable();
            $table->string('logo')->nullable(); // Path ke logo
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};