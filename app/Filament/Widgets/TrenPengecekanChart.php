<?php

namespace App\Filament\Widgets;

use App\Models\PengecekanMesin;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrenPengecekanChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pengecekan 7 Hari Terakhir';
    
    protected static ?int $sort = 6;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = ['md' => 1, 'xl' => 2];

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = '60s';

    public static function canView(): bool
    {
        return Auth::check();
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $countsByDate = PengecekanMesin::query()
            ->where('tanggal_pengecekan', '>=', $startDate)
            ->where('tanggal_pengecekan', '<=', $endDate)
            ->where('status', 'selesai')
            ->selectRaw('DATE(tanggal_pengecekan) as tanggal, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(tanggal_pengecekan)'))
            ->pluck('total', 'tanggal');

        for ($i = 0; $i <= 6; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateKey = $date->toDateString();

            $labels[] = $date->translatedFormat('d M');
            $data[] = (int) ($countsByDate[$dateKey] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengecekan Selesai',
                    'data' => $data,
                    'backgroundColor' => 'rgba(14, 165, 233, 0.2)',
                    'borderColor' => 'rgba(14, 165, 233, 1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
