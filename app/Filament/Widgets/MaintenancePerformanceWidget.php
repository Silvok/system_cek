<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceReport;
use App\Models\MLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MaintenancePerformanceWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        // Maintenance Reports this month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $reportStatusCounts = MaintenanceReport::query()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $completedThisMonth = (int) ($reportStatusCounts['completed'] ?? 0);
        $inProgressThisMonth = (int) ($reportStatusCounts['in_progress'] ?? 0);
        $pendingThisMonth = (int) ($reportStatusCounts['pending'] ?? 0);

        // Average completion time (completed in last 30 days)
        $avgCompletionHours = MaintenanceReport::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as average_hours')
            ->value('average_hours');

        $avgCompletionHours = round((float) ($avgCompletionHours ?? 0), 1);

        // Log perawatan stats
        $logStats = MLog::query()
            ->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed")
            ->first();

        $logsThisMonth = (int) ($logStats->total ?? 0);
        $logsCompleted = (int) ($logStats->completed ?? 0);

        // Spare parts usage this month
        $sparePartsUsed = (int) DB::table('m_log_spare_parts')
            ->join('m_logs', 'm_log_spare_parts.m_log_id', '=', 'm_logs.id')
            ->whereBetween('m_logs.tanggal_mulai', [$startOfMonth, $endOfMonth])
            ->sum('m_log_spare_parts.jumlah_digunakan');

        return [
            Stat::make('Laporan Maintenance Bulan Ini', $completedThisMonth)
                ->description("{$pendingThisMonth} pending, {$inProgressThisMonth} in progress")
                ->descriptionIcon('heroicon-o-clipboard-document-check')
                ->color('success')
                ->chart(array_fill(0, 7, rand(1, 10))),

            Stat::make('Rata-rata Waktu Penyelesaian', $avgCompletionHours . ' jam')
                ->description('30 hari terakhir')
                ->descriptionIcon('heroicon-o-clock')
                ->color($avgCompletionHours < 24 ? 'success' : ($avgCompletionHours < 48 ? 'warning' : 'danger')),

            Stat::make('Log Perawatan Bulan Ini', $logsThisMonth)
                ->description("{$logsCompleted} selesai")
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info')
                ->url('/admin/m-logs'),

            Stat::make('Suku Cadang Digunakan', $sparePartsUsed)
                ->description('Bulan ini')
                ->descriptionIcon('heroicon-o-cube')
                ->color('warning'),
        ];
    }
}
