<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;

    protected $table = 'student_progress';

    protected $fillable = [
        'santri_id',
        'date',
        'juz_start',
        'juz_end',
        'surah_memorized',
        'notes',
        'ustadz_user_id',
        'type',
    ];

    protected $casts = [
        'date'      => 'date',
        'juz_start' => 'integer',
        'juz_end'   => 'integer',
    ];

    // 114 Surah Al-Qur'an untuk Searchable Select
    public static array $surahList = [
        'Al-Fatihah', 'Al-Baqarah', 'Ali Imran', 'An-Nisa', 'Al-Ma\'idah',
        'Al-An\'am', 'Al-A\'raf', 'Al-Anfal', 'At-Taubah', 'Yunus',
        'Hud', 'Yusuf', 'Ar-Ra\'d', 'Ibrahim', 'Al-Hijr',
        'An-Nahl', 'Al-Isra', 'Al-Kahf', 'Maryam', 'Ta Ha',
        'Al-Anbiya', 'Al-Hajj', 'Al-Mu\'minun', 'An-Nur', 'Al-Furqan',
        'Asy-Syu\'ara', 'An-Naml', 'Al-Qasas', 'Al-Ankabut', 'Ar-Rum',
        'Luqman', 'As-Sajdah', 'Al-Ahzab', 'Saba', 'Fatir',
        'Ya Sin', 'As-Saffat', 'Sad', 'Az-Zumar', 'Gafir',
        'Fussilat', 'Asy-Syura', 'Az-Zukhruf', 'Ad-Dukhan', 'Al-Jasiyah',
        'Al-Ahqaf', 'Muhammad', 'Al-Fath', 'Al-Hujurat', 'Qaf',
        'Az-Zariyat', 'At-Tur', 'An-Najm', 'Al-Qamar', 'Ar-Rahman',
        'Al-Waqi\'ah', 'Al-Hadid', 'Al-Mujadilah', 'Al-Hasyr', 'Al-Mumtahanah',
        'As-Saf', 'Al-Jumu\'ah', 'Al-Munafiqun', 'At-Tagabun', 'At-Talaq',
        'At-Tahrim', 'Al-Mulk', 'Al-Qalam', 'Al-Haqqah', 'Al-Ma\'arij',
        'Nuh', 'Al-Jinn', 'Al-Muzammil', 'Al-Muddassir', 'Al-Qiyamah',
        'Al-Insan', 'Al-Mursalat', 'An-Naba', 'An-Nazi\'at', 'Abasa',
        'At-Takwir', 'Al-Infitar', 'Al-Mutaffifin', 'Al-Insyiqaq', 'Al-Buruj',
        'At-Tariq', 'Al-A\'la', 'Al-Gasiyah', 'Al-Fajr', 'Al-Balad',
        'Asy-Syams', 'Al-Lail', 'Ad-Duha', 'Asy-Syarh', 'At-Tin',
        'Al-Alaq', 'Al-Qadr', 'Al-Bayyinah', 'Az-Zalzalah', 'Al-Adiyat',
        'Al-Qari\'ah', 'At-Takasur', 'Al-Asr', 'Al-Humazah', 'Al-Fil',
        'Quraisy', 'Al-Ma\'un', 'Al-Kausar', 'Al-Kafirun', 'An-Nasr',
        'Al-Masad', 'Al-Ikhlas', 'Al-Falaq', 'An-Nas',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function ustadz()
    {
        return $this->belongsTo(User::class, 'ustadz_user_id');
    }

    public function getMateriSummaryAttribute(): string
    {
        if ($this->surah_memorized) {
            return $this->surah_memorized;
        }
        if ($this->juz_start && $this->juz_end) {
            return "Juz {$this->juz_start}–{$this->juz_end}";
        }
        return '-';
    }
}
