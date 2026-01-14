<?php

namespace App\Filament\Super\Resources\PanelAccesses\Schemas;

use App\Enums\AuthRole;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PanelAccessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('panel_id')
                    ->label('Panel ID')
                    ->required(),

                MultiSelect::make('role_access')
                    ->label('Role Access')
                    ->options(collect(AuthRole::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                    ->required(),
            ]);
    }
}
