<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceReport;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class TeknisiReminderWidget extends Widget
{
    protected string $view = 'filament.widgets.teknisi-reminder-simple';
    
    protected static ?int $sort = -4;

    protected static bool $isLazy = false;
    
    protected int | string | array $columnSpan = 'full';

    protected ?string $pollingInterval = '60s';

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->hasAnyRole(['Super Admin', 'Admin', 'Teknisi', 'Operator', 'Supervisor']);
    }

    public function getMessage(): array
    {
        $user = Auth::user();
        
        // Cek maintenance yang belum ada teknisi (pending tanpa teknisi)
        $maintenancePendingBelumDiambil = MaintenanceReport::where('status', 'pending')
            ->whereNull('teknisi_id')
            ->count();

        // Prioritas 1: Ada issue pending yang belum ada teknisi
        if ($maintenancePendingBelumDiambil > 0) {
            return [
                'type' => 'danger',
                'icon' => 'heroicon-o-exclamation-triangle',
                'title' => 'Perhatian! Issue Masuk, ' . $user->name,
                'message' => "Ada $maintenancePendingBelumDiambil laporan maintenance baru yang belum ditangani! Silakan ambil dan proses segera.",
            ];
        }

        $technicianStats = MaintenanceReport::where('teknisi_id', $user->id)
            ->selectRaw("SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress")
            ->selectRaw("SUM(CASE WHEN status != 'completed' AND tanggal_selesai IS NULL THEN 1 ELSE 0 END) as unfinished")
            ->selectRaw("SUM(CASE WHEN status = 'completed' AND tanggal_selesai >= ? AND tanggal_selesai <= ? THEN 1 ELSE 0 END) as completed_today", [today()->startOfDay(), today()->endOfDay()])
            ->first();

        // Prioritas 2: Ada maintenance yang sedang dikerjakan
        $maintenanceSedangDikerjakan = (int) ($technicianStats->in_progress ?? 0);

        if ($maintenanceSedangDikerjakan > 0) {
            return [
                'type' => 'warning',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'title' => 'Sedang Berjalan, ' . $user->name,
                'message' => "Anda sedang mengerjakan $maintenanceSedangDikerjakan maintenance. Jangan lupa selesaikan dan upload foto hasil perbaikan.",
            ];
        }

        // Prioritas 3: Ada maintenance yang belum selesai (pending yang sudah di-assign ke teknisi ini)
        $maintenanceBelumSelesai = (int) ($technicianStats->unfinished ?? 0);

        if ($maintenanceBelumSelesai > 0) {
            return [
                'type' => 'warning',
                'icon' => 'heroicon-o-clock',
                'title' => 'Pengingat Maintenance, ' . $user->name,
                'message' => "Anda memiliki $maintenanceBelumSelesai maintenance yang belum dimulai. Upload foto kondisi awal untuk memulai perbaikan.",
            ];
        } 
        
        // Kondisi normal: Semua selesai
        // Hanya tampilkan terima kasih jika teknisi menyelesaikan maintenance hari ini
        $maintenanceSelesaiHariIni = (int) ($technicianStats->completed_today ?? 0);

        if ($maintenanceSelesaiHariIni > 0) {
            return [
                'type' => 'success',
                'icon' => 'heroicon-o-check-circle',
                'title' => 'Terima Kasih, ' . $user->name . '!',
                'message' => "Anda telah menyelesaikan $maintenanceSelesaiHariIni maintenance hari ini. Kerja keras Anda sangat membantu!",
            ];
        }
        
        // Jika tidak ada yang diselesaikan hari ini, tampilkan status standby
        return [
            'type' => 'info',
            'icon' => 'heroicon-o-shield-check',
            'title' => 'Siap Bertugas, ' . $user->name . '!',
            'message' => "Tidak ada maintenance yang perlu ditangani saat ini. Tetap siaga untuk issue yang masuk.",
        ];
    }
}
