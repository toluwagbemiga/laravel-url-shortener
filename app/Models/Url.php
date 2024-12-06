<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    protected $fillable = [
        'original_url',
        'short_code',
        'clicks',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public static function generateShortCode(): string
    {
        do {
            $code = Str::random(6);
        } while (self::where('short_code', $code)->exists());

        return $code;
    }

    public function incrementClicks(): void
    {
        $this->increment('clicks');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
