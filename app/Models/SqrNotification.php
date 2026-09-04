<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqrNotification extends Model
{
    use HasFactory;

    protected $table = 'sqr_notifications';

    protected $fillable = [
        'user_id',
        'target_role',
        'title',
        'message',
        'is_read',
        'type'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId, string $role = 'wali')
    {
        return $query->where(function ($q) use ($userId, $role) {
            $q->where('user_id', $userId)
              ->orWhere('target_role', 'all')
              ->orWhere('target_role', $role);
        });
    }

    public function scopeForAdmin($query)
    {
        return $query->where(function ($q) {
            $q->where('target_role', 'admin')
              ->orWhere('type', 'ppdb')
              ->orWhere('type', 'spp_verification')
              ->orWhereNull('target_role');
        });
    }

    public function getTargetLabelAttribute(): string
    {
        if ($this->target_role === 'all') return 'Semua Pengguna';
        if ($this->target_role === 'ustadz') return 'Semua Pengajar / Ustadz';
        if ($this->target_role === 'wali') return 'Semua Wali Santri';
        if ($this->target_role === 'admin') return 'Admin System';
        if ($this->user_id) return $this->user?->name ?? 'User #' . $this->user_id;
        return 'Sistem';
    }

    public function getFormattedMessageHtmlAttribute(): string
    {
        $rawMessage = $this->message;
        $pattern = '/(https?:\/\/[^\s<]+)/i';

        if (preg_match($pattern, $rawMessage, $matches)) {
            $url = $matches[0];
            $escapedUrl = e($url);
            $escapedText = e($rawMessage);

            $inlineLink = '<a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer" class="font-bold underline text-blue-600 hover:text-blue-800 break-all">' . $escapedUrl . '</a>';
            $buttonHtml = '<div class="mt-2.5"><a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-title font-bold text-xs shadow-md transition transform hover:-translate-y-0.5"><i class="fa-solid fa-video text-sm"></i> Masuk Ruang Zoom / Meet →</a></div>';

            $replacedText = preg_replace($pattern, $inlineLink, $escapedText);
            return $replacedText . $buttonHtml;
        }

        return e($rawMessage);
    }
}
