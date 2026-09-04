<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sqr_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->default(-6.397637);
            $table->decimal('longitude', 10, 7)->default(106.877478);
            $table->unsignedInteger('radius_meters')->default(150);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'location_id')) {
                $table->foreignId('location_id')->nullable()->after('is_active')->constrained('sqr_locations')->nullOnDelete();
            }
        });

        Schema::table('classes', function (Blueprint $table) {
            if (!Schema::hasColumn('classes', 'location_id')) {
                $table->foreignId('location_id')->nullable()->after('ustadz_id')->constrained('sqr_locations')->nullOnDelete();
            }
        });

        // Seed Default Locations
        $now = now();
        $locationUtamaId = DB::table('sqr_locations')->insertGetId([
            'name'          => 'SQR Utama (Sukatani, Tapos Depok)',
            'code'          => 'SQR-UTAMA',
            'address'       => 'Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok',
            'latitude'      => -6.397637,
            'longitude'     => 106.877478,
            'radius_meters' => 150,
            'is_active'     => true,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        DB::table('sqr_locations')->insert([
            [
                'name'          => 'SQR Cabang Tapos',
                'code'          => 'SQR-TAPOS',
                'address'       => 'Jl. Raya Tapos No. 12, Tapos Depok',
                'latitude'      => -6.402000,
                'longitude'     => 106.882000,
                'radius_meters' => 150,
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'SQR Cabang Cimanggis',
                'code'          => 'SQR-CIMANGGIS',
                'address'       => 'Jl. Raya Bogor KM 30, Cimanggis Depok',
                'latitude'      => -6.365000,
                'longitude'     => 106.865000,
                'radius_meters' => 150,
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);

        // Assign default location SQR Utama to all existing users & classes
        DB::table('users')->update(['location_id' => $locationUtamaId]);
        DB::table('classes')->update(['location_id' => $locationUtamaId]);
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::dropIfExists('sqr_locations');
    }
};
