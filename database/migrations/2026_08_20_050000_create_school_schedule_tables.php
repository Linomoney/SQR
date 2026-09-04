<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Key-value store for schedule settings (jam masuk, jam pulang, libur mingguan, etc.)
        Schema::create('school_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Per-date events: holidays, special events, online classes, announcements
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('date_end')->nullable()->comment('For multi-day events/holidays');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['libur', 'acara', 'pengumuman', 'online'])->default('pengumuman');
            $table->boolean('is_holiday')->default(false)->comment('No classes on this day');
            $table->string('online_link')->nullable()->comment('Zoom/GMeet link for online type');
            $table->time('online_start_time')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete()->comment('Null = all classes');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_events');
        Schema::dropIfExists('school_schedules');
    }
};
