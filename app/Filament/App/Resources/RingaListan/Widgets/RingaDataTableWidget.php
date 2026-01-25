<?php

namespace App\Filament\App\Resources\RingaListan\Widgets;

use App\Filament\App\Resources\RingaListan\Tables\RingaDataTable;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RingaDataTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Ringlista';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return RingaDataTable::configure($table);
    }
}
