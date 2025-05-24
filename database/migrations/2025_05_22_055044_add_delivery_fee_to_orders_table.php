<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('delivery_fee', 10, 2)->default(0.00)->after('total_amount');
            // total_amount sekarang akan menjadi subtotal sebelum ongkir
            // kita mungkin perlu kolom baru untuk grand_total atau menyesuaikan logika
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_fee');
        });
    }
};