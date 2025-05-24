<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;   // Tambahkan ini

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'delivery_fee',
        'tenant_id',
        'order_code',
        'total_amount',
        'status',
        'pickup_time',
        'delivery_method',
        'delivery_address',
        'customer_notes',
        'payment_method',
        'payment_status',
        'payment_details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2', 
        'pickup_time' => 'datetime',
        'payment_details' => 'array', // Penting untuk kolom JSON
    ];

     public function getGrandTotalAttribute(): float
    {
        return (float)$this->total_amount + (float)$this->delivery_fee;
    }


    // Relasi: Satu Order dimiliki oleh satu User (customer)
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Satu Order ditujukan untuk satu Tenant
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    // Relasi: Satu Order memiliki banyak OrderItem
    public function items(): HasMany // Atau orderItems() jika lebih suka
    {
        return $this->hasMany(OrderItem::class);
    }
}