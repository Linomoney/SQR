<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('email_verified_at');
            $table->boolean('is_active')->default(true)->after('class_id');
            $table->text('address')->nullable()->after('is_active');
            $table->string('photo_url')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['class_id', 'is_active', 'address', 'photo_url']);
        });
    }
};
