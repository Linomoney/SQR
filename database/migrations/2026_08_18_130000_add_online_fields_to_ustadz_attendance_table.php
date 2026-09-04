<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ustadz_attendance', function (Blueprint $table) {
            $table->text('online_meeting_link')->nullable()->after('notes');
            $table->string('online_start_time', 10)->nullable()->after('online_meeting_link');
        });
    }

    public function down(): void
    {
        Schema::table('ustadz_attendance', function (Blueprint $table) {
            $table->dropColumn(['online_meeting_link', 'online_start_time']);
        });
    }
};
