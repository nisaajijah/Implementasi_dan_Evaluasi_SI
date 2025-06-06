<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini

class Canteen extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location_description',
        'operating_hours',
        'image',
    ];

    // Relasi: Satu Kantin bisa memiliki banyak Tenant
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}