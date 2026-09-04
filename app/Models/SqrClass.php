<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqrClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'description',
        'quota',
        'start_time',
        'end_time',
        'attendance_start_time',
        'attendance_end_time',
        'certificate_target',
        'recommendation_target',
        'location_id',
        'is_active',
    ];

    protected $casts = [
        'quota'                 => 'integer',
        'is_active'             => 'boolean',
        'certificate_target'    => 'integer',
        'recommendation_target' => 'integer',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['class_name'] ?? 'Kelas SQR';
    }

    public function getCategoryAttribute()
    {
        return 'Regular';
    }

    public function getScheduleAttribute()
    {
        $classStart = $this->start_time ?? '16:00';
        $classEnd   = $this->end_time ?? '18:00';
        $attStart   = $this->attendance_start_time ?? '15:30';
        $attEnd     = $this->attendance_end_time ?? '16:15';
        return "Kelas {$classStart} - {$classEnd} WIB (Batas Absen Ustadz: {$attStart} - {$attEnd} WIB)";
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'class_id');
    }

    public function activeSantri()
    {
        return $this->hasMany(Santri::class, 'class_id')->where('is_active', true);
    }

    public function ustadzList()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    // Helper: get first assigned ustadz for this class
    public function getUstadzAttribute()
    {
        return $this->ustadzList()->first();
    }

    public function ppdb()
    {
        return $this->hasMany(Ppdb::class, 'kelas_diminati');
    }


    public function santriAttendances()
    {
        return $this->hasMany(SantriAttendance::class, 'class_id');
    }

    public function isQuotaFull(): bool
    {
        return $this->activeSantri()->count() >= $this->quota;
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota - $this->activeSantri()->count());
    }

    public function getQuotaPercentageAttribute(): float
    {
        if ($this->quota <= 0) return 0;
        return min(100, ($this->activeSantri()->count() / $this->quota) * 100);
    }

    public function location()
    {
        return $this->belongsTo(SqrLocation::class, 'location_id');
    }
}
