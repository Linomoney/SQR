<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add certificate/recommendation targets to classes table
        Schema::table('classes', function (Blueprint $table) {
            if (!Schema::hasColumn('classes', 'certificate_target')) {
                $table->unsignedTinyInteger('certificate_target')->default(100)->after('attendance_end_time')
                    ->comment('Minimum progress % required for certificate (default 100%)');
            }
            if (!Schema::hasColumn('classes', 'recommendation_target')) {
                $table->unsignedTinyInteger('recommendation_target')->default(50)->after('certificate_target')
                    ->comment('Minimum progress % required for recommendation letter (default 50%)');
            }
        });

        // Add template selection and issued date to santri table
        Schema::table('santri', function (Blueprint $table) {
            if (!Schema::hasColumn('santri', 'certificate_template')) {
                $table->string('certificate_template', 30)->default('classic')->after('is_active')
                    ->comment('Selected certificate template: classic, elegant, premium');
            }
            if (!Schema::hasColumn('santri', 'certificate_issued_at')) {
                $table->timestamp('certificate_issued_at')->nullable()->after('certificate_template')
                    ->comment('When the official certificate was first issued/downloaded');
            }
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['certificate_target', 'recommendation_target']);
        });
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['certificate_template', 'certificate_issued_at']);
        });
    }
};
