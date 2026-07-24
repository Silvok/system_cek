<?php

namespace App\Filament\Widgets;

use App\Models\Mesin;
use App\Models\MComponent;
use App\Models\MRequest;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MachineStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $now = Carbon::now();

        $machineStatusCounts = Mesin::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalMesins = (int) $machineStatusCounts->sum();
        $activeMesins = (int) ($machineStatusCounts['aktif'] ?? 0);
        $maintenanceMesins = (int) ($machineStatusCounts['maintenance'] ?? 0);
        $brokenMesins = (int) ($machineStatusCounts['rusak'] ?? 0);

        $componentStats = MComponent::query()
            ->selectRaw("SUM(CASE WHEN status_komponen IN ('perlu_ganti', 'rusak') THEN 1 ELSE 0 END) as need_replacement")
            ->selectRaw('SUM(CASE WHEN estimasi_tanggal_ganti_berikutnya IS NOT NULL AND estimasi_tanggal_ganti_berikutnya < ? THEN 1 ELSE 0 END) as overdue', [$now])
            ->first();

        $componentNeedReplacement = (int) ($componentStats->need_replacement ?? 0);
        $componentOverdue = (int) ($componentStats->overdue ?? 0);

        $requestStatusCounts = MRequest::query()
            ->whereIn('status', ['pending', 'approved', 'in_progress'])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $pendingRequests = (int) (($requestStatusCounts['pending'] ?? 0) + ($requestStatusCounts['approved'] ?? 0));
        $inProgressRequests = (int) ($requestStatusCounts['in_progress'] ?? 0);

        // Mesin mendekati penggantian (30 hari)
        $machinesNearReplacement = Mesin::whereNotNull('estimasi_penggantian')
            ->whereBetween('estimasi_penggantian', [$now, $now->copy()->addDays(30)])
            ->count();

        return [
            Stat::make('Total Mesin', $totalMesins)
                ->description("{$activeMesins} aktif, {$maintenanceMesins} maintenance, {$brokenMesins} rusak")
                ->descriptionIcon('heroicon-o-cog')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->url('/admin/mesins'),

            Stat::make('Komponen Perlu Ganti', $componentNeedReplacement)
                ->description("{$componentOverdue} sudah terlambat")
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($componentNeedReplacement > 0 ? 'warning' : 'success')
                ->chart([3, 5, 8, 10, 7, 9, 12, 10]),

            Stat::make('Request Maintenance', $pendingRequests + $inProgressRequests)
                ->description("{$pendingRequests} pending, {$inProgressRequests} in progress")
                ->descriptionIcon('heroicon-o-wrench')
                ->color($pendingRequests > 5 ? 'danger' : 'info')
                ->chart([2, 4, 3, 5, 6, 4, 3, 5])
                ->url('/admin/m-requests'),

            Stat::make('Mesin Perlu Evaluasi', $machinesNearReplacement)
                ->description('Mendekati akhir umur ekonomis (30 hari)')
                ->descriptionIcon('heroicon-o-calendar')
                ->color($machinesNearReplacement > 0 ? 'warning' : 'success'),
        ];
    }
}
