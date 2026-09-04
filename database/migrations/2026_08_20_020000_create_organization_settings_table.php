<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default values
        $defaults = [
            'organization_name'        => 'Saung Quran Rabbani',
            'organization_subtitle'    => 'Lembaga Pendidikan Al-Qur\'an Terpadu',
            'organization_address'     => 'Jl. Rabbani No. 1, Bogor, Jawa Barat',
            'organization_phone'       => '(0251) 000-0000',
            'organization_email'       => 'info@sqr.id',
            'organization_city'        => 'Bogor',
            'pimpinan_name'            => 'Nama Pimpinan Lembaga',
            'pimpinan_title'           => 'Ketua/Pimpinan Saung Quran Rabbani',
            'pimpinan_signature_url'   => '',
            'organization_stamp_url'   => '',
            'organization_logo_url'    => 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1782638700/logo_sqr_atzzpb.png',
            'certificate_footer_text'  => 'Sertifikat ini dikeluarkan secara resmi oleh Saung Quran Rabbani dan dapat diverifikasi melalui pengurus lembaga.',
        ];

        foreach ($defaults as $key => $value) {
            \DB::table('organization_settings')->insertOrIgnore([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_settings');
    }
};
