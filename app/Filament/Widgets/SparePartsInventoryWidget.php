<?php

namespace App\Filament\Widgets;

use App\Models\SparePart;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SparePartsInventoryWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $inventoryStats = SparePart::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN stok > 0 AND stok <= stok_minimum THEN 1 ELSE 0 END) as low_stock')
            ->selectRaw('SUM(CASE WHEN stok <= 0 THEN 1 ELSE 0 END) as out_of_stock')
            ->selectRaw('COALESCE(SUM(stok * harga_satuan), 0) as total_value')
            ->first();

        $totalSpareParts = (int) ($inventoryStats->total ?? 0);
        $lowStock = (int) ($inventoryStats->low_stock ?? 0);
        $outOfStock = (int) ($inventoryStats->out_of_stock ?? 0);
        $totalValue = (float) ($inventoryStats->total_value ?? 0);

        $healthyStock = $totalSpareParts - $lowStock - $outOfStock;

        return [
            Stat::make('Total Item Suku Cadang', $totalSpareParts)
                ->description("{$healthyStock} stok sehat")
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary')
                ->url('/admin/spare-parts'),

            Stat::make('Stok Menipis', $lowStock)
                ->description('Perlu restock segera')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($lowStock > 0 ? 'warning' : 'success'),

            Stat::make('Stok Habis', $outOfStock)
                ->description('Tidak tersedia')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color($outOfStock > 0 ? 'danger' : 'success'),

            Stat::make('Nilai Inventaris', 'Rp ' . number_format($totalValue, 0, ',', '.'))
                ->description('Total nilai suku cadang')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }
}
