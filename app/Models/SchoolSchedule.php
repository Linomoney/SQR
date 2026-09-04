<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchoolSchedule extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key, with optional default.
     */
    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $record = static::where('key', $key)->first();
        return $record ? $record->value : $default;
    }

    /**
     * Set a setting value by key (upsert).
     */
    public static function setSetting(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get all settings as a key-value array.
     */
    public static function allSettings(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Returns the weekly off day numbers array (0=Sunday, 6=Saturday).
     * Defaults to [0, 6] (Sabtu & Minggu).
     */
    public static function weeklyOffDays(): array
    {
        $raw = static::getSetting('libur_mingguan', '6,0');
        if (is_numeric($raw)) {
            return [(int) $raw];
        }
        $parts = explode(',', (string) $raw);
        return array_map('intval', array_filter($parts, 'is_numeric'));
    }

    /**
     * Backward-compatibility helper for single weekly off day.
     */
    public static function weeklyOffDay(): int
    {
        $days = static::weeklyOffDays();
        return $days[0] ?? 0;
    }

    /**
     * Check if a specific dayOfWeek is a weekly off day.
     */
    public static function isWeeklyOffDay(int $dayOfWeek): bool
    {
        return in_array($dayOfWeek, static::weeklyOffDays(), true);
    }

    /**
     * Returns formatted jam masuk.
     */
    public static function jamMasuk(): string
    {
        return static::getSetting('jam_masuk', '16:00');
    }

    /**
     * Returns formatted jam pulang.
     */
    public static function jamPulang(): string
    {
        return static::getSetting('jam_pulang', '17:30');
    }

    /**
     * Determine if a given date (Carbon) is a school day.
     */
    public static function isSchoolDay(Carbon $date): bool
    {
        // If it's a weekly off day (Sabtu/Minggu)
        if (static::isWeeklyOffDay($date->dayOfWeek)) {
            return false;
        }

        // Check if there's a holiday event on this date
        $hasHoliday = SchoolEvent::onDate($date)->holidays()->exists();

        return !$hasHoliday;
    }

    /**
     * GPS Geolocation Helpers
     */
    public static function sqrLatitude(): float
    {
        return (float) static::getSetting('sqr_lat', '-6.397637');
    }

    public static function sqrLongitude(): float
    {
        return (float) static::getSetting('sqr_lng', '106.877478');
    }

    public static function sqrRadiusMeters(): int
    {
        return (int) static::getSetting('sqr_radius_meters', '100');
    }

    public static function rateHadirFisik(): float
    {
        return (float) static::getSetting('rate_hadir_fisik', '50000');
    }

    public static function rateHadirOnline(): float
    {
        return (float) static::getSetting('rate_hadir_online', '25000');
    }

    public static function rateSubstituteBonus(): float
    {
        return (float) static::getSetting('rate_substitute_bonus', '15000');
    }

    /**
     * Calculate distance between two lat/lng coordinates in meters using Haversine formula.
     */
    public static function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1);
    }
}
