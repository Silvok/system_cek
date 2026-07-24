<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addIndexIfMissing('pengecekan_mesins', ['tanggal_pengecekan', 'status'], 'pengecekan_mesins_date_status_idx');
        $this->addIndexIfMissing('pengecekan_mesins', ['user_id', 'tanggal_pengecekan', 'status'], 'pengecekan_mesins_user_date_status_idx');

        $this->addIndexIfMissing('mesins', 'status', 'mesins_status_idx');
        $this->addIndexIfMissing('mesins', 'estimasi_penggantian', 'mesins_estimasi_penggantian_idx');
        $this->addIndexIfMissing('mesins', 'created_at', 'mesins_created_at_idx');

        $this->addIndexIfMissing('m_components', 'status_komponen', 'm_components_status_komponen_idx');
        $this->addIndexIfMissing('m_components', 'estimasi_tanggal_ganti_berikutnya', 'm_components_estimasi_ganti_idx');

        $this->addIndexIfMissing('m_requests', ['status', 'requested_at'], 'm_requests_status_requested_idx');
        $this->addIndexIfMissing('m_requests', 'created_at', 'm_requests_created_at_idx');

        $this->addIndexIfMissing('maintenance_reports', ['status', 'created_at'], 'maintenance_reports_status_created_idx');
        $this->addIndexIfMissing('maintenance_reports', ['teknisi_id', 'status', 'tanggal_selesai'], 'maintenance_reports_teknisi_status_selesai_idx');

        $this->addIndexIfMissing('m_logs', ['tanggal_mulai', 'status'], 'm_logs_tanggal_mulai_status_idx');

        $this->addIndexIfMissing('spare_parts', 'status', 'spare_parts_status_idx');
        $this->addIndexIfMissing('spare_parts', 'created_at', 'spare_parts_created_at_idx');

        $this->addIndexIfMissing('spare_part_transactions', 'tanggal_transaksi', 'spare_part_transactions_tanggal_idx');
    }

    public function down(): void
    {
        $this->dropIndexIfExists('spare_part_transactions', 'spare_part_transactions_tanggal_idx');

        $this->dropIndexIfExists('spare_parts', 'spare_parts_status_idx');
        $this->dropIndexIfExists('spare_parts', 'spare_parts_created_at_idx');

        $this->dropIndexIfExists('m_logs', 'm_logs_tanggal_mulai_status_idx');

        $this->dropIndexIfExists('maintenance_reports', 'maintenance_reports_status_created_idx');
        $this->dropIndexIfExists('maintenance_reports', 'maintenance_reports_teknisi_status_selesai_idx');

        $this->dropIndexIfExists('m_requests', 'm_requests_status_requested_idx');
        $this->dropIndexIfExists('m_requests', 'm_requests_created_at_idx');

        $this->dropIndexIfExists('m_components', 'm_components_status_komponen_idx');
        $this->dropIndexIfExists('m_components', 'm_components_estimasi_ganti_idx');

        $this->dropIndexIfExists('mesins', 'mesins_status_idx');
        $this->dropIndexIfExists('mesins', 'mesins_estimasi_penggantian_idx');
        $this->dropIndexIfExists('mesins', 'mesins_created_at_idx');

        $this->dropIndexIfExists('pengecekan_mesins', 'pengecekan_mesins_date_status_idx');
        $this->dropIndexIfExists('pengecekan_mesins', 'pengecekan_mesins_user_date_status_idx');
    }

    private function addIndexIfMissing(string $tableName, string|array $columns, string $indexName): void
    {
        if (Schema::hasIndex($tableName, $indexName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($columns, $indexName) {
            $table->index($columns, $indexName);
        });
    }

    private function dropIndexIfExists(string $tableName, string $indexName): void
    {
        if (! Schema::hasIndex($tableName, $indexName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($indexName) {
            $table->dropIndex($indexName);
        });
    }
};
