<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table for Ustadz monthly bonuses set by Admin
        Schema::create('ustadz_payroll_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ustadz_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedSmallInteger('month');
            $table->unsignedSmallInteger('year');
            $table->decimal('bonus_amount', 12, 2)->default(0);
            $table->string('bonus_note', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['ustadz_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ustadz_payroll_bonuses');
    }
};
