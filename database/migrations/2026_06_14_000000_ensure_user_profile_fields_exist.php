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
                $table->string('alamat')->nullable();
            }

            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(false);
            }

            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil')->nullable();
            }

            if (!Schema::hasColumn('users', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }

            if (!Schema::hasColumn('users', 'spesialisasi')) {
                $table->string('spesialisasi')->nullable();
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

            if (Schema::hasColumn('users', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }

            if (Schema::hasColumn('users', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }

            if (Schema::hasColumn('users', 'spesialisasi')) {
                $table->dropColumn('spesialisasi');
            }
        });
    }
};
