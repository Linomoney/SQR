<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'income';

    protected $fillable = ['title', 'description', 'amount', 'date', 'category', 'recorded_by'];
    protected $casts = ['date' => 'date', 'amount' => 'integer'];

    public function getSourceAttribute()
    {
        return $this->attributes['title'] ?? 'Pemasukan';
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
