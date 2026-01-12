<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResetMerinfoQueueBulkAction extends BulkAction
{
    public static function make(?string $name = 'resetMerinfoQueue'): static
    {
        return parent::make($name)
            ->label('resetMerinfoQueue')
            ->icon('heroicon-o-users')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Bulk Queue resetMerinfoQueue')
            ->modalDescription('This will create a job batch resetMerinfoQueue.')
            ->modalSubmitActionLabel('resetMerinfoQueue')
            ->action(function (Collection $records): void {

                DB::table('post_nums')

                    ->update(['merinfo_personer_queue' => false]);

                Notification::make()
                    ->title('resetMerinfoQueue')
                    ->body('resetMerinfoQueue')
                    ->warning()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
