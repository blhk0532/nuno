<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\CarryData;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

final class CarryDataExporter extends Exporter
{
    protected static ?string $model = CarryData::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('person_lopnr'),
            ExportColumn::make('personnr'),
            ExportColumn::make('kon'),
            ExportColumn::make('civilstand'),
            ExportColumn::make('namn'),
            ExportColumn::make('fornamn'),
            ExportColumn::make('efternamn'),
            ExportColumn::make('adress'),
            ExportColumn::make('co_adress'),
            ExportColumn::make('postnr'),
            ExportColumn::make('ort'),
            ExportColumn::make('telefon'),
            ExportColumn::make('mobiltelefon'),
            ExportColumn::make('telefax'),
            ExportColumn::make('epost'),
            ExportColumn::make('epost_privat'),
            ExportColumn::make('epost_sekundar'),
            ExportColumn::make('is_hus'),
            ExportColumn::make('is_active'),
            ExportColumn::make('is_phone'),
            ExportColumn::make('is_epost'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your carry data export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
