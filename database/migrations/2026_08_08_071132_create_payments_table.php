<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->string('month_year', 7)->comment('Format: YYYY-MM');
            $table->unsignedBigInteger('amount')->default(0);
            $table->enum('status', ['Unpaid', 'Pending', 'Verified', 'Rejected'])->default('Unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('payment_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('wali_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('proof_image_path')->nullable();
            $table->enum('status', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_verifications');
        Schema::dropIfExists('payments');
    }
};
