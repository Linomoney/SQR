<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    use HasFactory;

    protected $table = 'ppdb';

    protected $fillable = [
        'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
        'no_hp_ayah', 'no_hp_ibu', 'penghasilan_bulanan',
        'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'anak_ke',
        'jumlah_saudara', 'sekolah_asal', 'gender',
        'email', 'no_telephone', 'alamat', 'rt', 'rw', 'desa_kelurahan', 'kota',
        'kelas_diminati', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anak_ke'       => 'integer',
        'jumlah_saudara'=> 'integer',
    ];

    public static array $pekerjaanOptions = [
        'PNS', 'Guru/Dosen', 'TNI/Polri', 'Pensiunan', 'Dokter', 'Politikus',
        'Pengacara', 'Pegawai Swasta', 'Wiraswasta', 'Seniman',
        'Petani/Nelayan', 'Buruh', 'Lainnya', 'Tidak Bekerja',
    ];

    public static array $penghasilanOptions = [
        'Rp. 500.000 - Rp. 1.000.000',
        'Rp. 1.000.000 - Rp. 3.000.000',
        'Rp. 3.000.000 - Rp. 5.000.000',
        'Rp. 5.000.000 - Rp. 10.000.000',
        'Rp. 10.000.000 - Rp. 20.000.000',
        'Rp. 20.000.000 - Rp. 50.000.000',
        '> Rp. 50.000.000',
    ];

    public function kelasDiminati()
    {
        return $this->belongsTo(SqrClass::class, 'kelas_diminati');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Diterima' => 'bg-emerald-100 text-emerald-800',
            'Ditolak'  => 'bg-red-100 text-red-700',
            default    => 'bg-amber-100 text-amber-800',
        };
    }
}
