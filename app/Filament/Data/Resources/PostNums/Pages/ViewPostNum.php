<?php

namespace App\Filament\Data\Resources\PostNums\Pages;

use App\Filament\Data\Resources\PostNums\PostNumResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPostNum extends ViewRecord
{
    protected static string $resource = PostNumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
