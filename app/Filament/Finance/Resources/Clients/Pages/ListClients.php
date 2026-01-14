<?php

namespace App\Filament\Finance\Resources\Clients\Pages;

use App\Filament\Finance\Actions\ClientTypeAction;
use App\Filament\Finance\Actions\EditTypeAction;
use App\Filament\Finance\Resources\Clients\ClientResource;
use App\Filament\Finance\Resources\Clients\Widgets\ClientsCountWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
               ->label(__('Create Client'))
               ->icon(Heroicon::UserCircle)
               ->button(),
        ClientTypeAction::make(),
        EditTypeAction::make()
        ];
    }
    protected function getHeaderWidgets(): array
    {
      return [
        ClientsCountWidget::class
      ];
    }

}
