<?php

declare(strict_types=1);

use App\Actions\TransferRatsitDataToRingaDataAction;
use App\Models\RatsitData;
use App\Models\RingaData;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('transfer action moves ratsit data to ringa data table', function () {
    // Create test RatsitData records
    $ratsitRecords = RatsitData::factory(3)->create([
        'personnamn' => 'Test Person',
        'personnummer' => '19900101-1234',
        'gatuadress' => 'Test Street 123',
        'postnummer' => '12345',
        'postort' => 'Test City',
    ]);

    // Assert records exist in ratsit_data table
    expect(RatsitData::count())->toBeGreaterThanOrEqual(3);
    expect(RingaData::count())->toBe(0);

    // Execute the transfer action
    $action = new TransferRatsitDataToRingaDataAction();
    $action->handle($ratsitRecords, ['user_id' => 1]);

    // Assert records were created in ringa_data table
    expect(RingaData::count())->toBe(3);

    // Verify data was copied correctly
    $ringaData = RingaData::first();
    expect($ringaData->personnamn)->toBe('Test Person');
    expect($ringaData->personnummer)->toBe('19900101-1234');
    expect($ringaData->gatuadress)->toBe('Test Street 123');
    expect($ringaData->postnummer)->toBe('12345');
    expect($ringaData->postort)->toBe('Test City');
    expect($ringaData->user_id)->toBe(1);
});

test('transfer action preserves all data types', function () {
    // Create a RatsitData record with various data types
    $ratsitRecord = RatsitData::factory()->create([
        'alder' => '45',
        'is_active' => true,
        'is_telefon' => false,
        'is_hus' => true,
        'telfonnummer' => ['555-1234', '555-5678'],
    ]);

    // Transfer the record
    $action = new TransferRatsitDataToRingaDataAction();
    $action->handle(collect([$ratsitRecord]), []);

    // Verify data types are preserved
    $ringaData = RingaData::first();
    expect($ringaData->alder)->toBe('45');
    expect($ringaData->is_active)->toBeTrue();
    expect($ringaData->is_telefon)->toBeFalse();
    expect($ringaData->is_hus)->toBeTrue();
    expect($ringaData->telfonnummer)->toBeArray();
    expect($ringaData->telfonnummer)->toEqual(['555-1234', '555-5678']);
});

test('transfer action sets correct default values', function () {
    $ratsitRecord = RatsitData::factory()->create();

    $action = new TransferRatsitDataToRingaDataAction();
    $action->handle(collect([$ratsitRecord]), []);

    $ringaData = RingaData::first();
    expect($ringaData->status)->toBeNull();
    expect($ringaData->outcome)->toBeNull();
    expect($ringaData->attempts)->toBe(0);
});
