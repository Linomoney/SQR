<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqrLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'latitude',
        'longitude',
        'radius_meters',
        'is_active',
    ];

    protected $casts = [
        'latitude'      => 'float',
        'longitude'     => 'float',
        'radius_meters' => 'integer',
        'is_active'     => 'boolean',
    ];

    public function ustadzList()
    {
        return $this->hasMany(User::class, 'location_id');
    }

    public function classes()
    {
        return $this->hasMany(SqrClass::class, 'location_id');
    }

    public static function getDefaultLocation(): ?self
    {
        return static::where('code', 'SQR-UTAMA')->first() ?? static::where('is_active', true)->first();
    }
}
