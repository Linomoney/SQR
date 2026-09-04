<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ustadz_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ustadz_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->default('Hadir');
            $table->time('check_in_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['ustadz_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ustadz_attendance');
    }
};
