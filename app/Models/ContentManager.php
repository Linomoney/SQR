<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentManager extends Model
{
    use HasFactory;

    protected $table = 'content_manager';

    protected $fillable = ['key', 'value', 'type', 'updated_by'];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get a content value by key with optional default
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $record = static::where('key', $key)->first();
        if (!$record) return $default;
        if ($record->type === 'json') {
            return json_decode($record->value, true) ?? $default;
        }
        if ($record->type === 'boolean') {
            return filter_var($record->value, FILTER_VALIDATE_BOOLEAN);
        }
        return $record->value ?? $default;
    }

    /**
     * Set content value by key
     */
    public static function setValue(string $key, mixed $value, string $type = 'text'): void
    {
        if ($type === 'json' && is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'updated_by' => auth()->id()]
        );
    }
}
