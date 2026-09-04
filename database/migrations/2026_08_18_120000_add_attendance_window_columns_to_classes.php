<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            if (!Schema::hasColumn('classes', 'attendance_start_time')) {
                $table->string('attendance_start_time', 10)->default('15:30')->after('end_time');
            }
            if (!Schema::hasColumn('classes', 'attendance_end_time')) {
                $table->string('attendance_end_time', 10)->default('16:15')->after('attendance_start_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['attendance_start_time', 'attendance_end_time']);
        });
    }
};
