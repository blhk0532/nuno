<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Users\Pages;

use Anish\TextInputEntry\Traits\TextInputEntryTrait;
use App\Filament\App\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewUser extends ViewRecord
{
    use TextInputEntryTrait;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
