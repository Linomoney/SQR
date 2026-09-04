<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id', 'month_year', 'amount', 'status', 'notes',
    ];

    protected $casts = ['amount' => 'integer'];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function verifications()
    {
        return $this->hasMany(PaymentVerification::class, 'payment_id');
    }

    public function latestVerification()
    {
        return $this->hasOne(PaymentVerification::class, 'payment_id')->latestOfMany();
    }

    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Verified' => 'bg-emerald-100 text-emerald-700',
            'Rejected' => 'bg-red-100 text-red-700',
            'Pending'  => 'bg-amber-100 text-amber-700',
            default    => 'bg-gray-100 text-gray-600',
        };
    }
}
