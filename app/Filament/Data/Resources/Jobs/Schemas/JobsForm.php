<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\Jobs\Schemas;

use Filament\Schemas\Schema;

final class JobsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
