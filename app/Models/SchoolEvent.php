<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'date_end', 'title', 'description',
        'type', 'is_holiday', 'online_link', 'online_start_time',
        'class_id', 'created_by',
    ];

    protected $casts = [
        'date'       => 'date',
        'date_end'   => 'date',
        'is_holiday' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────

    public function sqrClass()
    {
        return $this->belongsTo(SqrClass::class, 'class_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Scopes ─────────────────────────────────────────────────

    /** Events active on a specific date. */
    public function scopeOnDate($query, Carbon|string $date)
    {
        $d = $date instanceof Carbon ? $date->toDateString() : $date;

        return $query->where(function ($q) use ($d) {
            $q->where(function ($sub) use ($d) {
                $sub->whereNull('date_end')
                    ->where('date', '=', $d);
            })->orWhere(function ($sub) use ($d) {
                $sub->whereNotNull('date_end')
                    ->where('date', '<=', $d)
                    ->where('date_end', '>=', $d);
            });
        });
    }

    /** Events overlapping with a specific month/year. */
    public function scopeForMonth($query, int $year, int $month)
    {
        $start = Carbon::create($year, $month, 1)->toDateString();
        $end   = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();

        return $query->where(function ($q) use ($start, $end) {
            $q->where(function ($sub) use ($start, $end) {
                $sub->whereNull('date_end')
                    ->whereBetween('date', [$start, $end]);
            })->orWhere(function ($sub) use ($start, $end) {
                $sub->whereNotNull('date_end')
                    ->where('date', '<=', $end)
                    ->where('date_end', '>=', $start);
            });
        });
    }

    /** Today's events. */
    public function scopeToday($query)
    {
        return $query->onDate(today());
    }

    /** Upcoming events starting from today, ordered by date. */
    public function scopeUpcoming($query, int $days = 14)
    {
        return $query->where('date', '>=', today()->toDateString())
            ->where('date', '<=', today()->addDays($days)->toDateString())
            ->orderBy('date');
    }

    /** Only holiday events. */
    public function scopeHolidays($query)
    {
        return $query->where('is_holiday', true);
    }

    /** Online class events. */
    public function scopeOnlineClasses($query)
    {
        return $query->where('type', 'online');
    }

    // ── Accessors ──────────────────────────────────────────────

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'libur'       => '🔴 Libur',
            'acara'       => '🟡 Acara Khusus',
            'online'      => '🔵 Kelas Online',
            'pengumuman'  => '📢 Pengumuman',
            default       => ucfirst($this->type),
        };
    }

    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'libur'      => 'bg-red-100 text-red-700 border-red-200',
            'acara'      => 'bg-amber-100 text-amber-700 border-amber-200',
            'online'     => 'bg-blue-100 text-blue-700 border-blue-200',
            'pengumuman' => 'bg-purple-100 text-purple-700 border-purple-200',
            default      => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    public function getDateRangeAttribute(): string
    {
        if ($this->date_end && $this->date_end->ne($this->date)) {
            return $this->date->translatedFormat('d M') . ' – ' . $this->date_end->translatedFormat('d M Y');
        }
        return $this->date->translatedFormat('d F Y');
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'libur'      => '🔴',
            'acara'      => '🟡',
            'online'     => '🔵',
            'pengumuman' => '📢',
            default      => '📅',
        };
    }
}
