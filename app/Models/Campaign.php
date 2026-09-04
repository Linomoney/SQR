<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'target_amount',
        'current_amount',
        'excerpt',
        'description',
        'image_url',
        'bank_name',
        'bank_account',
        'bank_holder',
        'is_active',
        'end_date',
    ];

    protected $casts = [
        'target_amount'  => 'float',
        'current_amount' => 'float',
        'is_active'      => 'boolean',
        'end_date'       => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->title) . '-' . Str::random(4);
            }
        });
    }

    public function getPercentageProgressAttribute(): int
    {
        if ($this->target_amount <= 0) return 100;
        $pct = round(($this->current_amount / $this->target_amount) * 100);
        return min(100, (int) $pct);
    }

    public function getFormattedCurrentAttribute(): string
    {
        return 'Rp ' . number_format($this->current_amount, 0, ',', '.');
    }

    public function getFormattedTargetAttribute(): string
    {
        return 'Rp ' . number_format($this->target_amount, 0, ',', '.');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
