<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key terlebih dahulu
        try {
            Schema::table('pengecekan_mesins', function (Blueprint $table) {
                $table->dropForeign(['mesin_id']);
            });
        } catch (\Throwable $e) {
            // Foreign key mungkin tidak ada pada database yang sudah terlanjur termigrasi sebagian.
        }

        // Drop unique index yang bermasalah (jika ada)
        try {
            DB::statement('ALTER TABLE pengecekan_mesins DROP INDEX pengecekan_mesins_mesin_id_tanggal_pengecekan_unique');
        } catch (\Exception $e) {
            // Index mungkin tidak ada atau sudah dihapus
        }

        // Tambahkan generated column untuk tanggal saja
        if (! Schema::hasColumn('pengecekan_mesins', 'tanggal_only')) {
            DB::statement('ALTER TABLE pengecekan_mesins ADD COLUMN tanggal_only DATE AS (DATE(tanggal_pengecekan)) STORED');
        }

        // Buat unique index pada mesin_id dan tanggal_only
        Schema::table('pengecekan_mesins', function (Blueprint $table) {
            $table->unique(['mesin_id', 'tanggal_only'], 'pengecekan_mesins_mesin_id_date_unique');
        });

        // Tambahkan kembali foreign key
        try {
            Schema::table('pengecekan_mesins', function (Blueprint $table) {
                $table->foreign('mesin_id')->references('id')->on('mesins')->onDelete('cascade');
            });
        } catch (\Throwable $e) {
            // Foreign key mungkin sudah ada.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key
        try {
            Schema::table('pengecekan_mesins', function (Blueprint $table) {
                $table->dropForeign(['mesin_id']);
            });
        } catch (\Throwable $e) {
            // Foreign key mungkin tidak ada.
        }

        // Drop unique index
        Schema::table('pengecekan_mesins', function (Blueprint $table) {
            $table->dropUnique('pengecekan_mesins_mesin_id_date_unique');
        });

        // Drop generated column
        DB::statement('ALTER TABLE pengecekan_mesins DROP COLUMN tanggal_only');

        // Re-add foreign key
        Schema::table('pengecekan_mesins', function (Blueprint $table) {
            $table->foreign('mesin_id')->references('id')->on('mesins')->onDelete('cascade');
        });

        // Re-add old unique constraint  
        Schema::table('pengecekan_mesins', function (Blueprint $table) {
            $table->unique(['mesin_id', 'tanggal_pengecekan']);
        });
    }
};
