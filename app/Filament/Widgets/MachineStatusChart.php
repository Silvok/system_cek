<?php

namespace App\Filament\Widgets;

use App\Models\Mesin;
use Filament\Widgets\ChartWidget;

class MachineStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Mesin';

    protected static ?int $sort = 7;

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = ['md' => 1, 'xl' => 2];

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $statusCounts = Mesin::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $aktif = (int) ($statusCounts['aktif'] ?? 0);
        $nonaktif = (int) (($statusCounts['nonaktif'] ?? 0) + ($statusCounts['non-aktif'] ?? 0));
        $maintenance = (int) ($statusCounts['maintenance'] ?? 0);
        $rusak = (int) ($statusCounts['rusak'] ?? 0);

        return [
            'datasets' => [
                [
                    'label' => 'Status Mesin',
                    'data' => [$aktif, $nonaktif, $maintenance, $rusak],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(156, 163, 175)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                    ],
                ],
            ],
            'labels' => ['Aktif', 'Non-Aktif', 'Maintenance', 'Rusak'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
