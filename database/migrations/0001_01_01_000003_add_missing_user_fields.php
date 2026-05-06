<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->string('alamat')->nullable()->after('no_telepon');
            }

            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(false)->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('users', 'is_available')) {
                $table->dropColumn('is_available');
            }
        });
    }
};
