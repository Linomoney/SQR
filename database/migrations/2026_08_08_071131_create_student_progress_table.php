<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('juz_start')->nullable()->comment('Juz 1-30');
            $table->unsignedTinyInteger('juz_end')->nullable()->comment('Juz 1-30');
            $table->string('surah_memorized')->nullable()->comment('Nama surah yang dihafal');
            $table->text('notes')->nullable();
            $table->foreignId('ustadz_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['Tahsin', 'Tahfiz', 'Murojaah'])->default('Tahfiz');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};
