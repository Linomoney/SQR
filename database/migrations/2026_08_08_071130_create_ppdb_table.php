<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb', function (Blueprint $table) {
            $table->id();

            // Data Orang Tua / Wali
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->enum('pekerjaan_ayah', [
                'PNS', 'Guru/Dosen', 'TNI/Polri', 'Pensiunan', 'Dokter', 'Politikus',
                'Pengacara', 'Pegawai Swasta', 'Wiraswasta', 'Seniman',
                'Petani/Nelayan', 'Buruh', 'Lainnya', 'Tidak Bekerja'
            ])->nullable();
            $table->enum('pekerjaan_ibu', [
                'PNS', 'Guru/Dosen', 'TNI/Polri', 'Pensiunan', 'Dokter', 'Politikus',
                'Pengacara', 'Pegawai Swasta', 'Wiraswasta', 'Seniman',
                'Petani/Nelayan', 'Buruh', 'Lainnya', 'Tidak Bekerja'
            ])->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->enum('penghasilan_bulanan', [
                'Rp. 500.000 - Rp. 1.000.000',
                'Rp. 1.000.000 - Rp. 3.000.000',
                'Rp. 3.000.000 - Rp. 5.000.000',
                'Rp. 5.000.000 - Rp. 10.000.000',
                'Rp. 10.000.000 - Rp. 20.000.000',
                'Rp. 20.000.000 - Rp. 50.000.000',
                '> Rp. 50.000.000'
            ])->nullable();

            // Data Calon Peserta Didik
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedTinyInteger('anak_ke')->nullable();
            $table->unsignedTinyInteger('jumlah_saudara')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);

            // Data Alamat & Kontak
            $table->string('email')->nullable();
            $table->string('no_telephone')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kota')->nullable();

            // Metadata
            $table->foreignId('kelas_diminati')->nullable()->constrained('classes')->nullOnDelete();
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb');
    }
};
