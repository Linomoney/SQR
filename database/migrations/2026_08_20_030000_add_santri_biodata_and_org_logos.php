<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add birth_place and address to santri table if not exists
        Schema::table('santri', function (Blueprint $table) {
            if (!Schema::hasColumn('santri', 'birth_place')) {
                $table->string('birth_place', 100)->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('santri', 'address')) {
                $table->text('address')->nullable()->after('birth_place');
            }
        });

        // Insert default values for yayasan_logo_url and ustadz_signature_url in organization_settings
        $defaults = [
            'yayasan_logo_url'    => 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787212253/WhatsApp_Image_2024-03-05_at_16.45.18__1_-removebg-preview_1_n7ggrp.png',
            'ustadz_signature_url'=> '',
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
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['birth_place', 'address']);
        });
    }
};
