<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'nik',
        'no_kk',
        'phone',
        'birth_place',
        'birth_date',
        'education',
        'class_id',
        'location_id',
        'is_active',
        'address',
        'photo_url',
        'signature_url',
        'is_profile_completed',
    ];

    protected $casts = [
        'email_verified_at'    => 'datetime',
        'password'             => 'hashed',
        'is_active'            => 'boolean',
        'is_profile_completed' => 'boolean',
        'birth_date'           => 'date',
    ];

    public function getIsProfileDeadlinePassedAttribute(): bool
    {
        if ($this->is_profile_completed) {
            return false;
        }
        // If created_at is 3 days old or older, deadline is passed
        return $this->created_at ? now()->diffInDays($this->created_at) >= 3 : false;
    }

    public function getProfileDeadlineDateAttribute(): ?string
    {
        return $this->created_at ? $this->created_at->addDays(3)->translatedFormat('d F Y (H:i)') : null;
    }

    public function getCleanNameAttribute(): string
    {
        return trim(preg_replace('/^(Bpk\.?|Bapak|Ibu|Ust\.|Ustadz|Ustzah\.|Ustadzah)\s+/i', '', $this->name));
    }

    public function getWaliTitlePrefixAttribute(): string
    {
        if (in_array(strtoupper($this->gender ?? 'L'), ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE'])) {
            return 'Ibu';
        }
        return 'Bapak';
    }

    public function getFormattedWaliGreetingAttribute(): string
    {
        return $this->wali_title_prefix . ' ' . $this->clean_name;
    }

    public function getTeacherRoutePrefixAttribute(): string
    {
        if (in_array(strtoupper($this->gender ?? 'L'), ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE'])) {
            return 'ustadzah';
        }
        return 'ustadz';
    }

    public function getTitlePrefixAttribute(): string
    {
        if (in_array(strtoupper($this->gender ?? 'L'), ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE'])) {
            return 'Ustadzah';
        }
        return 'Ustadz';
    }

    public function getShortTitlePrefixAttribute(): string
    {
        if (in_array(strtoupper($this->gender ?? 'L'), ['P', 'PEREMPUAN', 'WOMAN', 'FEMALE'])) {
            return 'Ustzah.';
        }
        return 'Ust.';
    }

    public function getFormattedNameAttribute(): string
    {
        return $this->title_prefix . ' ' . $this->clean_name;
    }

    public function getFormattedShortNameAttribute(): string
    {
        return $this->short_title_prefix . ' ' . $this->clean_name;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function getClassIdAttribute()
    {
        return $this->attributes['class_id'] ?? null;
    }

    public function getRoleAttribute()
    {
        return $this->getRoleNames()->first() ?? 'user';
    }

    public function sqrClass()
    {
        return $this->belongsTo(SqrClass::class, 'class_id');
    }

    public function santriAsWali()
    {
        return $this->hasMany(Santri::class, 'wali_user_id');
    }

    public function progressInputted()
    {
        return $this->hasMany(StudentProgress::class, 'ustadz_user_id');
    }

    public function ustadzAttendances()
    {
        return $this->hasMany(UstadzAttendance::class, 'ustadz_id');
    }

    public function sqrNotifications()
    {
        return $this->hasMany(SqrNotification::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo_url) {
            return $this->photo_url;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2d4a22&color=fff&bold=true';
    }

    /**
     * Check if Wali has overdue SPP payment for past months (>= 1 month overdue) for any of their active children.
     */
    public function getHasOverdueSppAttribute(): bool
    {
        if (!$this->hasRole('wali')) {
            return false;
        }

        $santris = $this->santriAsWali()->where('is_active', true)->get();
        if ($santris->isEmpty()) {
            return false;
        }

        $prevMonthDate = now()->subMonth()->startOfMonth();
        $prevMonthYear = $prevMonthDate->format('Y-m');

        foreach ($santris as $santri) {
            $enrolledDate = $santri->enrollment_date ?? $santri->created_at;
            if ($enrolledDate && $enrolledDate->startOfMonth()->lte($prevMonthDate)) {
                $payment = Payment::where('santri_id', $santri->id)
                    ->where('month_year', $prevMonthYear)
                    ->first();

                if (!$payment || !in_array($payment->status, ['Verified', 'Pending'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if Wali has unpaid/unverified SPP for the current month.
     */
    public function getHasCurrentMonthUnpaidSppAttribute(): bool
    {
        if (!$this->hasRole('wali')) {
            return false;
        }

        $santris = $this->santriAsWali()->where('is_active', true)->get();
        if ($santris->isEmpty()) {
            return false;
        }

        $currentMonthYear = now()->format('Y-m');

        foreach ($santris as $santri) {
            $payment = Payment::where('santri_id', $santri->id)
                ->where('month_year', $currentMonthYear)
                ->first();

            if (!$payment || !in_array($payment->status, ['Verified', 'Pending'])) {
                return true;
            }
        }

        return false;
    }

    public function location()
    {
        return $this->belongsTo(SqrLocation::class, 'location_id');
    }
}
