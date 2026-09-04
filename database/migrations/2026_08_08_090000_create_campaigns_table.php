<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Sosial & Ta\'awun');
            $table->decimal('target_amount', 12, 2)->default(0);
            $table->decimal('current_amount', 12, 2)->default(0);
            $table->string('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('bank_name')->default('Bank Syariah Indonesia (BSI)');
            $table->string('bank_account')->default('7289-0123-45');
            $table->string('bank_holder')->default('Yayasan Bina Cahaya Ilmu Rabbani');
            $table->boolean('is_active')->default(true);
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
