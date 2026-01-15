<?php

namespace App\Filament\Product\Resources\Customers\Pages;

use App\Filament\Product\Resources\Customers\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
