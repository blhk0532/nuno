<?php

namespace App\Filament\Exports;

use App\Models\RatsitData;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class RatsitDataExporter extends Exporter
{
    protected static ?string $model = RatsitData::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID')
                ->enabledByDefault(false),
            ExportColumn::make('personnamn')
                ->label('Name'),
            ExportColumn::make('personnummer')
                ->label('Personnummer'),
            ExportColumn::make('fornamn')
                ->label('First Name'),
            ExportColumn::make('efternamn')
                ->label('Last Name'),
            ExportColumn::make('alder')
                ->label('Age'),
            ExportColumn::make('kon')
                ->label('Gender'),
            ExportColumn::make('fodelsedag')
                ->label('Date of Birth'),
            ExportColumn::make('civilstand')
                ->label('Civil Status'),
            ExportColumn::make('stjarntacken')
                ->label('Star Sign'),
            ExportColumn::make('gatuadress')
                ->label('Address'),
            ExportColumn::make('postnummer')
                ->label('Postnummer'),
            ExportColumn::make('postort')
                ->label('City'),
            ExportColumn::make('forsamling')
                ->label('Parish'),
            ExportColumn::make('kommun')
                ->label('Municipality'),
            ExportColumn::make('lan')
                ->label('County'),
            ExportColumn::make('adressandring')
                ->label('Address Change'),
            ExportColumn::make('telefon')
                ->label('Phone'),
            ExportColumn::make('telfonnummer')
                ->label('Alt Phone'),
            ExportColumn::make('epost_adress')
                ->label('Email'),
            ExportColumn::make('agandeform')
                ->label('Ownership'),
            ExportColumn::make('bostadstyp')
                ->label('Housing Type'),
            ExportColumn::make('boarea')
                ->label('Living Area'),
            ExportColumn::make('byggar')
                ->label('Build Year'),
            ExportColumn::make('fastighet')
                ->label('Property'),
            ExportColumn::make('personer')
                ->label('People'),
            ExportColumn::make('foretag')
                ->label('Companies'),
            ExportColumn::make('grannar')
                ->label('Neighbors'),
            ExportColumn::make('fordon')
                ->label('Vehicles'),
            ExportColumn::make('hundar')
                ->label('Dogs'),
            ExportColumn::make('bolagsengagemang')
                ->label('Board Positions'),
            ExportColumn::make('latitud')
                ->label('Latitude'),
            ExportColumn::make('longitude')
                ->label('Longitude'),
            ExportColumn::make('google_maps')
                ->label('Google Maps'),
            ExportColumn::make('google_streetview')
                ->label('Street View'),
            ExportColumn::make('ratsit_se')
                ->label('Ratsit Link'),
            ExportColumn::make('is_active')
                ->label('Active'),
            ExportColumn::make('is_queued')
                ->label('Queued'),
            ExportColumn::make('created_at')
                ->label('Created'),
            ExportColumn::make('updated_at')
                ->label('Updated'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ratsit data export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
