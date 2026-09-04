<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sqr_notifications', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('target_role')->nullable()->after('user_id')->comment('admin, ustadz, wali, all');
        });
    }

    public function down(): void
    {
        Schema::table('sqr_notifications', function (Blueprint $table) {
            $table->dropColumn('target_role');
        });
    }
};
