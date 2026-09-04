<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVerification extends Model
{
    use HasFactory;

    protected $table = 'payment_verifications';

    protected $fillable = [
        'payment_id', 'wali_user_id', 'proof_image_path',
        'status', 'admin_notes', 'verified_by', 'verified_at',
    ];

    protected $casts = ['verified_at' => 'datetime'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'wali_user_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
