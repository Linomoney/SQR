<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class OrganizationSetting extends Model
{
    protected $table = 'organization_settings';

    protected $fillable = ['key', 'value'];

    /**
     * Get all settings as a key-value array.
     */
    public static function getAllSettings(): array
    {
        return static::pluck('value', 'key')->toArray();
    }

    /**
     * Get all settings and automatically convert image URLs to base64 Data URIs for PDF rendering.
     */
    public static function getAllSettingsForPdf(): array
    {
        $settings = static::getAllSettings();

        $imageKeys = [
            'pimpinan_signature_url',
            'ustadz_signature_url',
            'organization_stamp_url',
            'organization_logo_url',
            'yayasan_logo_url',
        ];

        foreach ($imageKeys as $key) {
            $url = $settings[$key] ?? null;
            if (!empty($url)) {
                $base64 = static::imageToBase64($url);
                $settings[$key . '_base64'] = $base64;
            } else {
                $settings[$key . '_base64'] = null;
            }
        }

        return $settings;
    }

    /**
     * Convert an image URL (e.g. Cloudinary, local, external) into a base64 data URI string.
     */
    public static function imageToBase64(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_starts_with($url, 'data:image')) {
            return $url;
        }

        try {
            // First attempt with cURL if available
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                $data = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($data !== false && $httpCode >= 200 && $httpCode < 300 && strlen($data) > 0) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_buffer($finfo, $data) ?: 'image/png';
                    finfo_close($finfo);
                    return 'data:' . $mimeType . ';base64,' . base64_encode($data);
                }
            }

            // Fallback to stream_context
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ],
                'http' => [
                    'timeout'    => 10,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                ],
            ]);

            $data = @file_get_contents($url, false, $context);
            if ($data !== false && strlen($data) > 0) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $data) ?: 'image/png';
                finfo_close($finfo);
                return 'data:' . $mimeType . ';base64,' . base64_encode($data);
            }
        } catch (\Throwable $e) {
            Log::error("Failed to convert image to base64 for PDF: " . $e->getMessage());
        }

        return $url;
    }

    /**
     * Get a single setting value by key.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Set a value (upsert).
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Set multiple values at once.
     */
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::set($key, $value);
        }
    }
}
