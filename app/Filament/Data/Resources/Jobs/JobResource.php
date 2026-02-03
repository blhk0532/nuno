<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\Jobs;

use App\Filament\Data\Resources\Jobs\Pages\CreateJob;
use App\Filament\Data\Resources\Jobs\Pages\EditJob;
use App\Filament\Data\Resources\Jobs\Pages\ListJobs;
use App\Filament\Data\Resources\Jobs\Pages\ViewJob;
use App\Filament\Data\Resources\Jobs\Schemas\JobForm;
use App\Filament\Data\Resources\Jobs\Schemas\JobInfolist;
use App\Filament\Data\Resources\Jobs\Tables\JobsTable;
use App\Filament\Data\Resources\Jobs\Widgets\QueueMonitorWidget;
use App\Models\Job;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

final class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Jobs Queue 🔥';

    protected static ?string $modelLabel = 'Job';

    protected static ?string $pluralModelLabel = 'Jobs';

    protected static ?int $navigationSort = 1;

    protected static UnitEnum|string|null $navigationGroup = 'Tasks Queue';

    public static function form(Schema $schema): Schema
    {
        return JobForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'view' => ViewJob::route('/{record}'),
            'edit' => EditJob::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) self::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getWidgets(): array
    {
        return [
            QueueMonitorWidget::class,
        ];
    }
}
