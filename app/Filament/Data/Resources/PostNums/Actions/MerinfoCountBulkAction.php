<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class MerinfoCountBulkAction extends BulkAction
{
    public static function make(?string $name = 'merinfoCount'): static
    {
        return parent::make($name)
            ->label('Merinfo Count')
            ->icon('heroicon-o-calculator')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Set Merinfo Count')
            ->modalDescription('This will set merinfo_personer_count = 1 for all selected post numbers.')
            ->modalSubmitActionLabel('Set Count')
            ->action(function (Collection $records): void {
                $count = 0;
                foreach ($records as $record) {
                    $record->update(['merinfo_personer_count' => 1]);
                    $count++;
                }

                Notification::make()
                    ->success()
                    ->title('Merinfo Count Updated')
                    ->body("Successfully set merinfo_personer_count = 1 for {$count} post nummer(s).")
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
