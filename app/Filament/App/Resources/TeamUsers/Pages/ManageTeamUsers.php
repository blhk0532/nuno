<?php

namespace App\Filament\App\Resources\TeamUsers\Pages;

use App\Filament\App\Resources\TeamUsers\TeamUserResource;
use App\Models\Membership;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageTeamUsers extends ManageRecords
{
    protected static string $resource = TeamUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function (Model $record) {
                    $tenant = filament()->getTenant();
                    if ($tenant) {
                        Membership::create([
                            'team_id' => $tenant->id,
                            'user_id' => $record->id,
                        ]);
                    }
                }),
        ];
    }
}
