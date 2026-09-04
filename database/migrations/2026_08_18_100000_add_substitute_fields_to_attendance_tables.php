<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ustadz_attendance', function (Blueprint $table) {
            if (!Schema::hasColumn('ustadz_attendance', 'substitute_ustadz_id')) {
                $table->foreignId('substitute_ustadz_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('santri_attendance', function (Blueprint $table) {
            if (!Schema::hasColumn('santri_attendance', 'substitute_ustadz_id')) {
                $table->foreignId('substitute_ustadz_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ustadz_attendance', function (Blueprint $table) {
            $table->dropForeign(['substitute_ustadz_id']);
            $table->dropColumn('substitute_ustadz_id');
        });

        Schema::table('santri_attendance', function (Blueprint $table) {
            $table->dropForeign(['substitute_ustadz_id']);
            $table->dropColumn('substitute_ustadz_id');
        });
    }
};
