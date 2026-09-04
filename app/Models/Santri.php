<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'birth_place',
        'address',
        'gender',
        'parent_name',
        'phone',
        'wali_user_id',
        'class_id',
        'enrollment_date',
        'is_active',
        'certificate_template',
        'certificate_issued_at',
    ];

    protected $casts = [
        'date_of_birth'        => 'date',
        'enrollment_date'      => 'date',
        'is_active'            => 'boolean',
        'certificate_issued_at'=> 'datetime',
    ];

    // ─── Accessors Failsafe (Alias camelCase ke snake_case) ────────
    public function getFullNameAttribute()
    {
        return $this->attributes['full_name'] ?? null;
    }

    public function getClassIdAttribute()
    {
        return $this->attributes['class_id'] ?? null;
    }

    public function getWaliUserIdAttribute()
    {
        return $this->attributes['wali_user_id'] ?? null;
    }

    public function getBirthPlaceAttribute()
    {
        return $this->attributes['birth_place'] ?? $this->wali?->birth_place ?? 'Depok';
    }

    public function getAddressAttribute()
    {
        return $this->attributes['address'] ?? $this->wali?->address ?? 'Kota Depok, Jawa Barat';
    }

    public function getNisAttribute()
    {
        return 'SQR-' . date('Y') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    // ─── Relasi ────────────────────────────────────────────────
    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_user_id');
    }

    public function sqrClass()
    {
        return $this->belongsTo(SqrClass::class, 'class_id');
    }

    public function studentProgress()
    {
        return $this->hasMany(StudentProgress::class, 'santri_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'santri_id');
    }

    public function attendances()
    {
        return $this->hasMany(SantriAttendance::class, 'santri_id');
    }

    // ─── Relasi Ustadz Pengampu Terakhir ──────────────────────────
    public function lastUstadz()
    {
        // Get the ustadz who last recorded progress for this santri
        return $this->hasOne(StudentProgress::class, 'santri_id')
            ->latest('date')
            ->with('ustadz');
    }

    public function getLastUstadzUserAttribute()
    {
        $lastProgress = $this->studentProgress()->latest('date')->with('ustadz')->first();
        return $lastProgress?->ustadz;
    }

    // ─── Gamifikasi: Kalkulasi Progress Hafalan ─────────────────
    public const TARGET_JUZ = 30;
    public const RECOMMENDATION_THRESHOLD = 50;

    /** Get effective certificate target (from class setting or default 100%) */
    public function getCertificateTargetAttribute(): int
    {
        return $this->sqrClass?->certificate_target ?? 100;
    }

    /** Get effective recommendation target (from class setting or default 50%) */
    public function getRecommendationTargetAttribute(): int
    {
        return $this->sqrClass?->recommendation_target ?? 50;
    }

    public function getTotalJuzMemorisedAttribute(): float
    {
        // Tahsin IS EXCLUDED (Tahsin is for reading improvement, does NOT count towards memorization progress or certificates)
        $tahfizMurojaahProgress = $this->studentProgress()
            ->whereIn('type', ['Tahfiz', 'Murojaah'])
            ->get();

        if ($tahfizMurojaahProgress->isEmpty()) {
            return 0;
        }

        $maxJuzEnd = $tahfizMurojaahProgress->max('juz_end') ?? 0;
        return (float) $maxJuzEnd;
    }

    public function getTotalJuzTahfizAttribute(): float
    {
        $max = $this->studentProgress()->where('type', 'Tahfiz')->max('juz_end') ?? 0;
        return (float) $max;
    }

    public function getTotalJuzMurojaahAttribute(): float
    {
        $max = $this->studentProgress()->where('type', 'Murojaah')->max('juz_end') ?? 0;
        return (float) $max;
    }

    public function getProgressPercentageAttribute(): float
    {
        $totalJuz = $this->total_juz_memorised;
        return min(100, round(($totalJuz / self::TARGET_JUZ) * 100, 1));
    }

    public function isEligibleForCertificate(): bool
    {
        return $this->progress_percentage >= $this->certificate_target;
    }

    public function isEligibleForTahfizCertificate(): bool
    {
        return $this->total_juz_tahfiz >= self::TARGET_JUZ || $this->progress_percentage >= $this->certificate_target;
    }

    public function isEligibleForMurojaahCertificate(): bool
    {
        return $this->total_juz_murojaah >= 10 || $this->studentProgress()->where('type', 'Murojaah')->count() >= 5;
    }

    public function isEligibleForRecommendation(): bool
    {
        return $this->progress_percentage >= $this->recommendation_target;
    }

    public function getCanDownloadRecommendationAttribute(): bool
    {
        return $this->isEligibleForRecommendation();
    }

    public function getCanDownloadCertificateAttribute(): bool
    {
        return $this->isEligibleForCertificate();
    }

    public function getAttendanceStreakAttribute(): int
    {
        $streak = 0;
        $cursor = today();
        $daysChecked = 0;
        $maxLookback = 60; // Max days to look back

        while ($daysChecked < $maxLookback) {
            // Check if day is weekly off or calendar holiday
            $isSchool = SchoolSchedule::isSchoolDay($cursor);

            if (!$isSchool) {
                // Skip holidays & weekends (do NOT break streak, do NOT count as school day)
                $cursor = $cursor->copy()->subDay();
                $daysChecked++;
                continue;
            }

            // On a school day, check attendance
            $att = SantriAttendance::where('santri_id', $this->id)
                ->whereDate('date', $cursor)
                ->first();

            if ($att && in_array($att->status, ['Hadir', 'Izin'])) {
                $streak++;
                $cursor = $cursor->copy()->subDay();
                $daysChecked++;
            } else {
                // If today is a school day and not recorded yet, don't break streak if checking today
                if ($cursor->isToday() && !$att) {
                    $cursor = $cursor->copy()->subDay();
                    $daysChecked++;
                    continue;
                }
                // Missed a school day -> streak breaks
                break;
            }
        }

        return $streak;
    }

    public function getProgressSummaryAttribute(): array
    {
        $latest = $this->studentProgress()->latest('date')->first();
        return [
            'completedJuzCount'        => $this->total_juz_memorised,
            'progressPercentage'       => $this->progress_percentage,
            'percentage'               => $this->progress_percentage,
            'total_juz'                => $this->total_juz_memorised,
            'target_juz'               => self::TARGET_JUZ,
            'total_sessions'           => $this->studentProgress()->count(),
            'tahsin_sessions'          => $this->studentProgress()->where('type', 'Tahsin')->count(),
            'tahfiz_sessions'          => $this->studentProgress()->where('type', 'Tahfiz')->count(),
            'murojaah_sessions'        => $this->studentProgress()->where('type', 'Murojaah')->count(),
            'attendance_streak'        => $this->attendance_streak,
            'latest_date'              => $latest?->date?->format('d M Y'),
            'latest_type'              => $latest?->type,
            'is_certified'             => $this->isEligibleForCertificate(),
            'is_certified_tahfiz'      => $this->isEligibleForTahfizCertificate(),
            'is_certified_murojaah'    => $this->isEligibleForMurojaahCertificate(),
            'is_recommended'           => $this->isEligibleForRecommendation(),
        ];
    }
}
