<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Pages;

use App\Filament\App\Resources\RingaDatas\RingaDatasResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditRingaData extends EditRecord
{
    protected static string $resource = RingaDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
