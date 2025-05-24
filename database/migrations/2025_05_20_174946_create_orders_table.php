<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pembeli
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // Tenant yang dipesan
            $table->string('order_code')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', [
                'pending_payment', 'paid', 'processing', 'ready_for_pickup',
                'out_for_delivery', 'delivered', 'completed', 'cancelled'
            ])->default('pending_payment');
            $table->dateTime('pickup_time')->nullable();
            $table->enum('delivery_method', ['pickup', 'delivery']);
            $table->text('delivery_address')->nullable();
            $table->text('customer_notes')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'refunded'])->default('unpaid');
            $table->json('payment_details')->nullable(); // Untuk menyimpan metadata pembayaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};