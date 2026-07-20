<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MesinResource;
use App\Models\Mesin;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class MesinsLofi extends Page
{
    protected static ?string $slug = 'mesins-lofi';

    protected static ?string $title = 'xxxxxxxxxx';

    protected static bool $shouldRegisterNavigation = false;

    public function getView(): string
    {
        return 'filament.pages.mesins-lofi';
    }

    public function getBreadcrumbs(): array
    {
        return [
            MesinResource::getUrl('index') => 'xxxxxxxxxx',
            'xxxx',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf_lofi')
                ->label('xxxxx xxx')
                ->icon(Heroicon::OutlinedDocumentArrowDown)
                ->color('gray')
                ->disabled(),

            Action::make('export_excel_lofi')
                ->label('xxxxx xxxxx')
                ->icon(Heroicon::OutlinedDocumentArrowDown)
                ->color('gray')
                ->disabled(),

            Action::make('tambah_mesin_lofi')
                ->label('xxxxxx xxxxx')
                ->icon(Heroicon::OutlinedPlus)
                ->color('gray')
                ->disabled(),
        ];
    }

    public function placeholderRows(): int
    {
        return min(Mesin::count(), 8);
    }
}
