<?php

namespace App\Filament\Data\Resources\PostNums;

use App\Filament\Data\Resources\PostNums\Pages\CreatePostNum;
use App\Filament\Data\Resources\PostNums\Pages\EditPostNum;
use App\Filament\Data\Resources\PostNums\Pages\ListPostNums;
use App\Filament\Data\Resources\PostNums\Pages\ViewPostNum;
use App\Filament\Data\Resources\PostNums\Schemas\PostNumForm;
use App\Filament\Data\Resources\PostNums\Schemas\PostNumInfolist;
use App\Filament\Data\Resources\PostNums\Tables\PostNumsTable;
use App\Models\PostNum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PostNumResource extends Resource
{
    protected static ?string $model = PostNum::class;

    protected static ?string $slug = 'post-nums';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Post Nummer';

    protected static ?int $navigationSort = 0;

    protected static UnitEnum|string|null $navigationGroup = 'Tasks Queue';

    public static function form(Schema $schema): Schema
    {
        return PostNumForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PostNumInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostNumsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostNums::route('/'),
            'create' => CreatePostNum::route('/create'),
            'view' => ViewPostNum::route('/{record}'),
            'edit' => EditPostNum::route('/{record}/edit'),
        ];
    }
}
