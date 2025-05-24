<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany;   // Tambahkan ini

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'canteen_id',
        'name',
        'description',
        'logo',
        'is_open',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'boolean',
    ];

    // Relasi: Satu Tenant dimiliki oleh satu User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Tenant berada di satu Kantin
    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    // Relasi: Satu Tenant memiliki banyak MenuItem
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    // Relasi: Satu Tenant bisa menerima banyak Order
    public function ordersReceived(): HasMany
    {
        return $this->hasMany(Order::class, 'tenant_id');
    }
}