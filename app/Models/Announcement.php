<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Admin yang membuat
        'title',
        'content',
        'published_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relasi: Satu Pengumuman dibuat oleh satu User (Author/Admin)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}