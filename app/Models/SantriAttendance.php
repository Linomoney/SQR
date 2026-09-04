<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriAttendance extends Model
{
    use HasFactory;

    protected $table = 'santri_attendance';

    protected $fillable = [
        'santri_id',
        'class_id',
        'date',
        'status',
        'recorded_by',
        'substitute_ustadz_id',
        'notes',
    ];

    protected $casts = ['date' => 'date'];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function sqrClass()
    {
        return $this->belongsTo(SqrClass::class, 'class_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function substituteUstadz()
    {
        return $this->belongsTo(User::class, 'substitute_ustadz_id');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Hadir'  => 'bg-emerald-100 text-emerald-700',
            'Izin'   => 'bg-blue-100 text-blue-700',
            'Sakit'  => 'bg-amber-100 text-amber-700',
            default  => 'bg-red-100 text-red-700',
        };
    }
}
