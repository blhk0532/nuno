<?php

namespace App\Filament\Exports;

use App\Models\PostNum;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PostNumExporter extends Exporter
{
    protected static ?string $model = PostNum::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('post_nummer')
                ->label('Post Nummer'),
            ExportColumn::make('post_ort')
                ->label('Post Ort'),
            ExportColumn::make('post_lan')
                ->label('Post Län'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('is_active')
                ->label('Active'),
            ExportColumn::make('hitta_personer_total')
                ->label('Hitta Personer Total'),
            ExportColumn::make('hitta_foretag_total')
                ->label('Hitta Företag Total'),
            ExportColumn::make('hitta_personer_saved')
                ->label('Hitta Personer Saved'),
            ExportColumn::make('hitta_foretag_saved')
                ->label('Hitta Företag Saved'),
            ExportColumn::make('hitta_personer_queue')
                ->label('Hitta Personer Queue'),
            ExportColumn::make('hitta_foretag_queue')
                ->label('Hitta Företag Queue'),
            ExportColumn::make('ratsit_personer_total')
                ->label('Ratsit Personer Total'),
            ExportColumn::make('ratsit_foretag_total')
                ->label('Ratsit Företag Total'),
            ExportColumn::make('ratsit_personer_saved')
                ->label('Ratsit Personer Saved'),
            ExportColumn::make('ratsit_foretag_saved')
                ->label('Ratsit Företag Saved'),
            ExportColumn::make('ratsit_personer_queue')
                ->label('Ratsit Personer Queue'),
            ExportColumn::make('ratsit_foretag_queue')
                ->label('Ratsit Företag Queue'),
            ExportColumn::make('merinfo_personer_total')
                ->label('Merinfo Personer Total'),
            ExportColumn::make('merinfo_foretag_total')
                ->label('Merinfo Företag Total'),
            ExportColumn::make('merinfo_personer_saved')
                ->label('Merinfo Personer Saved'),
            ExportColumn::make('merinfo_foretag_saved')
                ->label('Merinfo Företag Saved'),
            ExportColumn::make('merinfo_personer_queue')
                ->label('Merinfo Personer Queue'),
            ExportColumn::make('merinfo_foretag_queue')
                ->label('Merinfo Företag Queue'),
            ExportColumn::make('created_at')
                ->label('Created'),
            ExportColumn::make('updated_at')
                ->label('Updated'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your post nums export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
