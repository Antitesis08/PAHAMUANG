<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom profil konsultan: tarif, rating, jumlah_ulasan, bidang.
     * Kolom ini dipakai agar data konsultan konsisten di semua halaman
     * (beranda, list, detail, booking, checkout).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tarif')) {
                $table->decimal('tarif', 15, 0)->nullable();
            }

            if (!Schema::hasColumn('users', 'rating')) {
                $table->decimal('rating', 2, 1)->nullable();
            }

            if (!Schema::hasColumn('users', 'jumlah_ulasan')) {
                $table->unsignedInteger('jumlah_ulasan')->nullable()->default(0);
            }

            if (!Schema::hasColumn('users', 'bidang')) {
                $table->string('bidang')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tarif')) {
                $table->dropColumn('tarif');
            }
            if (Schema::hasColumn('users', 'rating')) {
                $table->dropColumn('rating');
            }
            if (Schema::hasColumn('users', 'jumlah_ulasan')) {
                $table->dropColumn('jumlah_ulasan');
            }
            if (Schema::hasColumn('users', 'bidang')) {
                $table->dropColumn('bidang');
            }
        });
    }
};
