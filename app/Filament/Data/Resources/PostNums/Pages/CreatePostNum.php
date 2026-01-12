<?php

namespace App\Filament\Data\Resources\PostNums\Pages;

use App\Filament\Data\Resources\PostNums\PostNumResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostNum extends CreateRecord
{
    protected static string $resource = PostNumResource::class;
}
