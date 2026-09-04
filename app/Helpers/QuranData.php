<?php

namespace App\Helpers;

class QuranData
{
    /**
     * Data 30 Juz Al-Qur'an lengkap dengan daftar surah dan rentang ayat.
     */
    public static array $juzMap = [
        1  => [
            ['surah_no' => 1,  'name' => 'Al-Fatihah', 'start_verse' => 1, 'end_verse' => 7],
            ['surah_no' => 2,  'name' => 'Al-Baqarah', 'start_verse' => 1, 'end_verse' => 141],
        ],
        2  => [
            ['surah_no' => 2,  'name' => 'Al-Baqarah', 'start_verse' => 142, 'end_verse' => 252],
        ],
        3  => [
            ['surah_no' => 2,  'name' => 'Al-Baqarah', 'start_verse' => 253, 'end_verse' => 286],
            ['surah_no' => 3,  'name' => 'Ali Imran',  'start_verse' => 1,   'end_verse' => 92],
        ],
        4  => [
            ['surah_no' => 3,  'name' => 'Ali Imran',  'start_verse' => 93,  'end_verse' => 200],
            ['surah_no' => 4,  'name' => 'An-Nisa',    'start_verse' => 1,   'end_verse' => 23],
        ],
        5  => [
            ['surah_no' => 4,  'name' => 'An-Nisa',    'start_verse' => 24,  'end_verse' => 147],
        ],
        6  => [
            ['surah_no' => 4,  'name' => 'An-Nisa',    'start_verse' => 148, 'end_verse' => 176],
            ['surah_no' => 5,  'name' => 'Al-Ma\'idah','start_verse' => 1,   'end_verse' => 81],
        ],
        7  => [
            ['surah_no' => 5,  'name' => 'Al-Ma\'idah','start_verse' => 82,  'end_verse' => 120],
            ['surah_no' => 6,  'name' => 'Al-An\'am',  'start_verse' => 1,   'end_verse' => 110],
        ],
        8  => [
            ['surah_no' => 6,  'name' => 'Al-An\'am',  'start_verse' => 111, 'end_verse' => 165],
            ['surah_no' => 7,  'name' => 'Al-A\'raf',  'start_verse' => 1,   'end_verse' => 87],
        ],
        9  => [
            ['surah_no' => 7,  'name' => 'Al-A\'raf',  'start_verse' => 88,  'end_verse' => 206],
            ['surah_no' => 8,  'name' => 'Al-Anfal',   'start_verse' => 1,   'end_verse' => 40],
        ],
        10 => [
            ['surah_no' => 8,  'name' => 'Al-Anfal',   'start_verse' => 41,  'end_verse' => 75],
            ['surah_no' => 9,  'name' => 'At-Taubah',  'start_verse' => 1,   'end_verse' => 92],
        ],
        11 => [
            ['surah_no' => 9,  'name' => 'At-Taubah',  'start_verse' => 93,  'end_verse' => 129],
            ['surah_no' => 10, 'name' => 'Yunus',      'start_verse' => 1,   'end_verse' => 109],
            ['surah_no' => 11, 'name' => 'Hud',        'start_verse' => 1,   'end_verse' => 5],
        ],
        12 => [
            ['surah_no' => 11, 'name' => 'Hud',        'start_verse' => 6,   'end_verse' => 123],
            ['surah_no' => 12, 'name' => 'Yusuf',      'start_verse' => 1,   'end_verse' => 52],
        ],
        13 => [
            ['surah_no' => 12, 'name' => 'Yusuf',      'start_verse' => 53,  'end_verse' => 111],
            ['surah_no' => 13, 'name' => 'Ar-Ra\'d',   'start_verse' => 1,   'end_verse' => 43],
            ['surah_no' => 14, 'name' => 'Ibrahim',    'start_verse' => 1,   'end_verse' => 52],
            ['surah_no' => 15, 'name' => 'Al-Hijr',    'start_verse' => 1,   'end_verse' => 99],
        ],
        14 => [
            ['surah_no' => 16, 'name' => 'An-Nahl',    'start_verse' => 1,   'end_verse' => 128],
        ],
        15 => [
            ['surah_no' => 17, 'name' => 'Al-Isra',    'start_verse' => 1,   'end_verse' => 111],
            ['surah_no' => 18, 'name' => 'Al-Kahf',    'start_verse' => 1,   'end_verse' => 74],
        ],
        16 => [
            ['surah_no' => 18, 'name' => 'Al-Kahf',    'start_verse' => 75,  'end_verse' => 110],
            ['surah_no' => 19, 'name' => 'Maryam',     'start_verse' => 1,   'end_verse' => 98],
            ['surah_no' => 20, 'name' => 'Ta Ha',      'start_verse' => 1,   'end_verse' => 135],
        ],
        17 => [
            ['surah_no' => 21, 'name' => 'Al-Anbiya',  'start_verse' => 1,   'end_verse' => 112],
            ['surah_no' => 22, 'name' => 'Al-Hajj',    'start_verse' => 1,   'end_verse' => 78],
        ],
        18 => [
            ['surah_no' => 23, 'name' => 'Al-Mu\'minun','start_verse' => 1,  'end_verse' => 118],
            ['surah_no' => 24, 'name' => 'An-Nur',      'start_verse' => 1,  'end_verse' => 64],
            ['surah_no' => 25, 'name' => 'Al-Furqan',  'start_verse' => 1,   'end_verse' => 20],
        ],
        19 => [
            ['surah_no' => 25, 'name' => 'Al-Furqan',  'start_verse' => 21,  'end_verse' => 77],
            ['surah_no' => 26, 'name' => 'Asy-Syu\'ara','start_verse' => 1,  'end_verse' => 227],
            ['surah_no' => 27, 'name' => 'An-Naml',    'start_verse' => 1,   'end_verse' => 55],
        ],
        20 => [
            ['surah_no' => 27, 'name' => 'An-Naml',    'start_verse' => 56,  'end_verse' => 93],
            ['surah_no' => 28, 'name' => 'Al-Qasas',   'start_verse' => 1,   'end_verse' => 88],
            ['surah_no' => 29, 'name' => 'Al-Ankabut', 'start_verse' => 1,   'end_verse' => 45],
        ],
        21 => [
            ['surah_no' => 29, 'name' => 'Al-Ankabut', 'start_verse' => 46,  'end_verse' => 69],
            ['surah_no' => 30, 'name' => 'Ar-Rum',     'start_verse' => 1,   'end_verse' => 60],
            ['surah_no' => 31, 'name' => 'Luqman',     'start_verse' => 1,   'end_verse' => 34],
            ['surah_no' => 32, 'name' => 'As-Sajdah',  'start_verse' => 1,   'end_verse' => 30],
            ['surah_no' => 33, 'name' => 'Al-Ahzab',   'start_verse' => 1,   'end_verse' => 30],
        ],
        22 => [
            ['surah_no' => 33, 'name' => 'Al-Ahzab',   'start_verse' => 31,  'end_verse' => 73],
            ['surah_no' => 34, 'name' => 'Saba',       'start_verse' => 1,   'end_verse' => 54],
            ['surah_no' => 35, 'name' => 'Fatir',      'start_verse' => 1,   'end_verse' => 45],
            ['surah_no' => 36, 'name' => 'Ya Sin',     'start_verse' => 1,   'end_verse' => 27],
        ],
        23 => [
            ['surah_no' => 36, 'name' => 'Ya Sin',     'start_verse' => 28,  'end_verse' => 83],
            ['surah_no' => 37, 'name' => 'As-Saffat',  'start_verse' => 1,   'end_verse' => 182],
            ['surah_no' => 38, 'name' => 'Sad',        'start_verse' => 1,   'end_verse' => 88],
            ['surah_no' => 39, 'name' => 'Az-Zumar',   'start_verse' => 1,   'end_verse' => 31],
        ],
        24 => [
            ['surah_no' => 39, 'name' => 'Az-Zumar',   'start_verse' => 32,  'end_verse' => 75],
            ['surah_no' => 40, 'name' => 'Gafir',      'start_verse' => 1,   'end_verse' => 85],
            ['surah_no' => 41, 'name' => 'Fussilat',   'start_verse' => 1,   'end_verse' => 46],
        ],
        25 => [
            ['surah_no' => 41, 'name' => 'Fussilat',   'start_verse' => 47,  'end_verse' => 54],
            ['surah_no' => 42, 'name' => 'Asy-Syura',  'start_verse' => 1,   'end_verse' => 53],
            ['surah_no' => 43, 'name' => 'Az-Zukhruf', 'start_verse' => 1,   'end_verse' => 89],
            ['surah_no' => 44, 'name' => 'Ad-Dukhan',  'start_verse' => 1,   'end_verse' => 59],
            ['surah_no' => 45, 'name' => 'Al-Jasiyah', 'start_verse' => 1,   'end_verse' => 37],
        ],
        26 => [
            ['surah_no' => 46, 'name' => 'Al-Ahqaf',   'start_verse' => 1,   'end_verse' => 35],
            ['surah_no' => 47, 'name' => 'Muhammad',   'start_verse' => 1,   'end_verse' => 38],
            ['surah_no' => 48, 'name' => 'Al-Fath',    'start_verse' => 1,   'end_verse' => 29],
            ['surah_no' => 49, 'name' => 'Al-Hujurat', 'start_verse' => 1,   'end_verse' => 18],
            ['surah_no' => 50, 'name' => 'Qaf',        'start_verse' => 1,   'end_verse' => 45],
            ['surah_no' => 51, 'name' => 'Az-Zariyat', 'start_verse' => 1,   'end_verse' => 30],
        ],
        27 => [
            ['surah_no' => 51, 'name' => 'Az-Zariyat', 'start_verse' => 31,  'end_verse' => 60],
            ['surah_no' => 52, 'name' => 'At-Tur',     'start_verse' => 1,   'end_verse' => 49],
            ['surah_no' => 53, 'name' => 'An-Najm',    'start_verse' => 1,   'end_verse' => 62],
            ['surah_no' => 54, 'name' => 'Al-Qamar',   'start_verse' => 1,   'end_verse' => 55],
            ['surah_no' => 55, 'name' => 'Ar-Rahman',  'start_verse' => 1,   'end_verse' => 78],
            ['surah_no' => 56, 'name' => 'Al-Waqi\'ah','start_verse' => 1,   'end_verse' => 96],
            ['surah_no' => 57, 'name' => 'Al-Hadid',   'start_verse' => 1,   'end_verse' => 29],
        ],
        28 => [
            ['surah_no' => 58, 'name' => 'Al-Mujadilah','start_verse' => 1,  'end_verse' => 22],
            ['surah_no' => 59, 'name' => 'Al-Hasyr',   'start_verse' => 1,   'end_verse' => 24],
            ['surah_no' => 60, 'name' => 'Al-Mumtahanah','start_verse' => 1,'end_verse' => 13],
            ['surah_no' => 61, 'name' => 'As-Saf',     'start_verse' => 1,   'end_verse' => 14],
            ['surah_no' => 62, 'name' => 'Al-Jumu\'ah','start_verse' => 1,   'end_verse' => 11],
            ['surah_no' => 63, 'name' => 'Al-Munafiqun','start_verse' => 1,  'end_verse' => 11],
            ['surah_no' => 64, 'name' => 'At-Tagabun', 'start_verse' => 1,   'end_verse' => 18],
            ['surah_no' => 65, 'name' => 'At-Talaq',   'start_verse' => 1,   'end_verse' => 12],
            ['surah_no' => 66, 'name' => 'At-Tahrim',  'start_verse' => 1,   'end_verse' => 12],
        ],
        29 => [
            ['surah_no' => 67, 'name' => 'Al-Mulk',    'start_verse' => 1,   'end_verse' => 30],
            ['surah_no' => 68, 'name' => 'Al-Qalam',   'start_verse' => 1,   'end_verse' => 52],
            ['surah_no' => 69, 'name' => 'Al-Haqqah',  'start_verse' => 1,   'end_verse' => 52],
            ['surah_no' => 70, 'name' => 'Al-Ma\'arij','start_verse' => 1,   'end_verse' => 44],
            ['surah_no' => 71, 'name' => 'Nuh',        'start_verse' => 1,   'end_verse' => 28],
            ['surah_no' => 72, 'name' => 'Al-Jinn',    'start_verse' => 1,   'end_verse' => 28],
            ['surah_no' => 73, 'name' => 'Al-Muzammil','start_verse' => 1,   'end_verse' => 20],
            ['surah_no' => 74, 'name' => 'Al-Muddassir','start_verse' => 1,  'end_verse' => 56],
            ['surah_no' => 75, 'name' => 'Al-Qiyamah','start_verse' => 1,   'end_verse' => 40],
            ['surah_no' => 76, 'name' => 'Al-Insan',   'start_verse' => 1,   'end_verse' => 31],
            ['surah_no' => 77, 'name' => 'Al-Mursalat','start_verse' => 1,   'end_verse' => 50],
        ],
        30 => [
            ['surah_no' => 78, 'name' => 'An-Naba',    'start_verse' => 1,   'end_verse' => 40],
            ['surah_no' => 79, 'name' => 'An-Nazi\'at','start_verse' => 1,   'end_verse' => 46],
            ['surah_no' => 80, 'name' => 'Abasa',      'start_verse' => 1,   'end_verse' => 42],
            ['surah_no' => 81, 'name' => 'At-Takwir',  'start_verse' => 1,   'end_verse' => 29],
            ['surah_no' => 82, 'name' => 'Al-Infitar', 'start_verse' => 1,   'end_verse' => 19],
            ['surah_no' => 83, 'name' => 'Al-Mutaffifin','start_verse' => 1, 'end_verse' => 36],
            ['surah_no' => 84, 'name' => 'Al-Insyiqaq','start_verse' => 1,   'end_verse' => 25],
            ['surah_no' => 85, 'name' => 'Al-Buruj',   'start_verse' => 1,   'end_verse' => 22],
            ['surah_no' => 86, 'name' => 'At-Tariq',   'start_verse' => 1,   'end_verse' => 17],
            ['surah_no' => 87, 'name' => 'Al-A\'la',   'start_verse' => 1,   'end_verse' => 19],
            ['surah_no' => 88, 'name' => 'Al-Gasiyah', 'start_verse' => 1,   'end_verse' => 26],
            ['surah_no' => 89, 'name' => 'Al-Fajr',    'start_verse' => 1,   'end_verse' => 30],
            ['surah_no' => 90, 'name' => 'Al-Balad',   'start_verse' => 1,   'end_verse' => 20],
            ['surah_no' => 91, 'name' => 'Asy-Syams',  'start_verse' => 1,   'end_verse' => 15],
            ['surah_no' => 92, 'name' => 'Al-Lail',    'start_verse' => 1,   'end_verse' => 21],
            ['surah_no' => 93, 'name' => 'Ad-Duha',    'start_verse' => 1,   'end_verse' => 11],
            ['surah_no' => 94, 'name' => 'Asy-Syarh',  'start_verse' => 1,   'end_verse' => 8],
            ['surah_no' => 95, 'name' => 'At-Tin',     'start_verse' => 1,   'end_verse' => 8],
            ['surah_no' => 96, 'name' => 'Al-Alaq',    'start_verse' => 1,   'end_verse' => 19],
            ['surah_no' => 97, 'name' => 'Al-Qadr',    'start_verse' => 1,   'end_verse' => 5],
            ['surah_no' => 98, 'name' => 'Al-Bayyinah','start_verse' => 1,   'end_verse' => 8],
            ['surah_no' => 99, 'name' => 'Az-Zalzalah','start_verse' => 1,   'end_verse' => 8],
            ['surah_no' => 100,'name' => 'Al-Adiyat',  'start_verse' => 1,   'end_verse' => 11],
            ['surah_no' => 101,'name' => 'Al-Qari\'ah','start_verse' => 1,   'end_verse' => 11],
            ['surah_no' => 102,'name' => 'At-Takasur', 'start_verse' => 1,   'end_verse' => 8],
            ['surah_no' => 103,'name' => 'Al-Asr',     'start_verse' => 1,   'end_verse' => 3],
            ['surah_no' => 104,'name' => 'Al-Humazah', 'start_verse' => 1,   'end_verse' => 9],
            ['surah_no' => 105,'name' => 'Al-Fil',     'start_verse' => 1,   'end_verse' => 5],
            ['surah_no' => 106,'name' => 'Quraisy',    'start_verse' => 1,   'end_verse' => 4],
            ['surah_no' => 107,'name' => 'Al-Ma\'un',   'start_verse' => 1,   'end_verse' => 7],
            ['surah_no' => 108,'name' => 'Al-Kausar',  'start_verse' => 1,   'end_verse' => 3],
            ['surah_no' => 109,'name' => 'Al-Kafirun', 'start_verse' => 1,   'end_verse' => 6],
            ['surah_no' => 110,'name' => 'An-Nasr',    'start_verse' => 1,   'end_verse' => 3],
            ['surah_no' => 111,'name' => 'Al-Masad',   'start_verse' => 1,   'end_verse' => 5],
            ['surah_no' => 112,'name' => 'Al-Ikhlas',  'start_verse' => 1,   'end_verse' => 4],
            ['surah_no' => 113,'name' => 'Al-Falaq',   'start_verse' => 1,   'end_verse' => 5],
            ['surah_no' => 114,'name' => 'An-Nas',     'start_verse' => 1,   'end_verse' => 6],
        ],
    ];

    public static function getSurahsForJuz(int $juz): array
    {
        return static::$juzMap[$juz] ?? [];
    }
}
