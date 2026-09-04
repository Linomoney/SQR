<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UstadzAttendance extends Model
{
    use HasFactory;

    protected $table = 'ustadz_attendance';

    protected $fillable = [
        'ustadz_id',
        'date',
        'status',
        'check_in_time',
        'notes',
        'substitute_ustadz_id',
        'online_meeting_link',
        'online_start_time',
        'latitude',
        'longitude',
        'distance_meters',
        'is_within_radius',
    ];

    protected $casts = ['date' => 'date'];

    public function getUstadzUserIdAttribute()
    {
        return $this->attributes['ustadz_id'] ?? null;
    }

    public function ustadz()
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }

    public function substituteUstadz()
    {
        return $this->belongsTo(User::class, 'substitute_ustadz_id');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Hadir'        => 'bg-emerald-100 text-emerald-700',
            'Hadir Online' => 'bg-purple-100 text-purple-700',
            'Izin'         => 'bg-blue-100 text-blue-700',
            'Sakit'        => 'bg-amber-100 text-amber-700',
            default        => 'bg-red-100 text-red-700',
        };
    }
}
