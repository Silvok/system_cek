<?php

namespace App\Filament\Widgets;

use App\Models\DaftarPengecekan;
use App\Models\PengecekanMesin;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusPengecekanOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;
    
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $totalDaftarPengecekan = DaftarPengecekan::count();

        $todayStatusCounts = PengecekanMesin::query()
            ->where('tanggal_pengecekan', '>=', today()->startOfDay())
            ->where('tanggal_pengecekan', '<=', today()->endOfDay())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $sudahDicek = (int) ($todayStatusCounts['selesai'] ?? 0);
        $sedangDicek = (int) ($todayStatusCounts['dalam_proses'] ?? 0);
        $tidakAdaData = max(0, $totalDaftarPengecekan - $sudahDicek - $sedangDicek);

        $persentaseSelesai = $totalDaftarPengecekan > 0 
            ? round(($sudahDicek / $totalDaftarPengecekan) * 100, 1) 
            : 0;

        return [
            Stat::make('Total Daftar Pengecekan', $totalDaftarPengecekan)
                ->description('Jumlah daftar pengecekan')
                ->descriptionIcon('heroicon-o-server')
                ->color('primary'),

            Stat::make('Sudah Dicek', $sudahDicek)
                ->description("$persentaseSelesai% selesai")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Sedang Dicek', $sedangDicek)
                ->description('Proses berlangsung')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Tidak Ada Data/Tidak Dicek', $tidakAdaData)
                ->description('Belum ada pengecekan')
                ->descriptionIcon('heroicon-o-minus-circle')
                ->color('gray'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }

    public function getDisplayName(): string
    {
        return 'Status Pengecekan Hari Ini - ' . now()->translatedFormat('d F Y');
    }
}
