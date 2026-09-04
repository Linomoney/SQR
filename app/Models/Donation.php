<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'donor_name',
        'donor_phone',
        'donor_email',
        'amount',
        'payment_method',
        'status',
        'notes',
        'proof_image',
    ];

    protected $casts = [
        'amount' => 'double',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
