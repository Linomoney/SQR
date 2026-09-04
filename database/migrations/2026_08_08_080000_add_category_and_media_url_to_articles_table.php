<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'category')) {
                $table->string('category')->default('Kegiatan')->after('slug');
            }
            if (!Schema::hasColumn('articles', 'media_url')) {
                $table->string('media_url')->nullable()->after('image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['category', 'media_url']);
        });
    }
};
