<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'no_kk')) {
                $table->string('no_kk', 20)->nullable()->after('nik');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('no_kk');
            }
            if (!Schema::hasColumn('users', 'birth_place')) {
                $table->string('birth_place', 100)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('birth_place');
            }
            if (!Schema::hasColumn('users', 'education')) {
                $table->string('education', 100)->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('users', 'is_profile_completed')) {
                $table->boolean('is_profile_completed')->default(false)->after('photo_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'phone', 'birth_place', 'birth_date', 'education', 'is_profile_completed'
            ]);
        });
    }
};
