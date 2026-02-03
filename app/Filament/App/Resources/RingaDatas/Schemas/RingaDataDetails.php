<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class RingaDataDetails
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('gatuadress')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('postnummer')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('postort')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('adressandring')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('personnummer')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('alder')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('kon')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('civilstand')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('personnamn')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('telefon')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('agandeform')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('bostadstyp')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('boarea')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('byggar')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->placeholder('-')
                    ->badge(),
                TextEntry::make('user_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
