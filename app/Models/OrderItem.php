<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'price_at_purchase',
        'sub_total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price_at_purchase' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    // Relasi: Satu OrderItem milik satu Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: Satu OrderItem merujuk ke satu MenuItem
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}