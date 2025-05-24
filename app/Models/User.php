<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Jika Anda menggunakan verifikasi email dari Breeze
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 

// Tambahkan use statement untuk relasi
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable // implements MustVerifyEmail (jika ada)
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Sudah ditambahkan sebelumnya
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Breeze biasanya menambahkan ini
    ];

    // Relasi: Seorang User bisa memiliki satu profil Tenant (jika 1 user = 1 tenant)
    public function tenantProfile(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    // Relasi: Seorang User (sebagai customer) bisa memiliki banyak Order
    public function ordersAsCustomer(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Relasi: Seorang User (sebagai admin) bisa membuat banyak Announcement
    public function announcementsAuthored(): HasMany
    {
        return $this->hasMany(Announcement::class, 'user_id');
    }
}