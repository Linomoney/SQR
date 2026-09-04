<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UstadzPayrollBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'ustadz_id',
        'month',
        'year',
        'bonus_amount',
        'bonus_note',
        'created_by',
    ];

    protected $casts = [
        'bonus_amount' => 'decimal:2',
        'month'        => 'integer',
        'year'         => 'integer',
    ];

    public function ustadz()
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
