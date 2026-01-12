<?php

namespace App\Filament\Exports;

use App\Models\MerinfoData;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MerinfoDataExporter extends Exporter
{
    protected static ?string $model = MerinfoData::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID')
                ->enabledByDefault(false),
            ExportColumn::make('personnamn')
                ->label('Personnamn'),
            ExportColumn::make('alder')
                ->label('Ålder'),
            ExportColumn::make('kon')
                ->label('Kön'),
            ExportColumn::make('gatuadress')
                ->label('Gatuadress'),
            ExportColumn::make('postnummer')
                ->label('Postnummer'),
            ExportColumn::make('postort')
                ->label('Postort'),
            ExportColumn::make('telefon')
                ->label('Telefon'),
            ExportColumn::make('karta')
                ->label('Karta'),
            ExportColumn::make('link')
                ->label('Länk'),
            ExportColumn::make('bostadstyp')
                ->label('Bostadstyp'),
            ExportColumn::make('bostadspris')
                ->label('Bostadspris'),
            ExportColumn::make('merinfo_personer_total')
                ->label('Merinfo Personer Total'),
            ExportColumn::make('merinfo_foretag_total')
                ->label('Merinfo Företag Total'),
            ExportColumn::make('is_active')
                ->label('Aktiv'),
            ExportColumn::make('is_telefon')
                ->label('Har telefon'),
            ExportColumn::make('is_ratsit')
                ->label('Från Ratsit'),
            ExportColumn::make('is_hus')
                ->label('Är hus'),
            ExportColumn::make('created_at')
                ->label('Skapad'),
            ExportColumn::make('updated_at')
                ->label('Uppdaterad'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your merinfo data export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
