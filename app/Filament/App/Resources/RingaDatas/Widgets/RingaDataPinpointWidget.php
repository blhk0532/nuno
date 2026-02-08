<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Widgets;

use App\Models\RingaData;
use Fahiem\FilamentPinpoint\Pinpoint;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

final class RingaDataPinpointWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?RingaData $record = null;

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-pinpoint-widget';

    protected int|string|array $columnSpan = 'md';

    protected static ?string $heading = '';

    protected $listeners = ['record-selected' => 'updateRecord'];

    public function updateRecord(int $recordId): void
    {
        $this->record = RingaData::find($recordId);
        if ($this->record && $this->record->latitud && $this->record->longitude) {
            $this->data = [
                'location' => null,
                'lat' => $this->record->latitud,
                'lng' => $this->record->longitude,
                'address' => $this->record->gatuadress ?? null,
            ];

            // Force Livewire to refresh the component
            $this->dispatch('$refresh');
        }
    }

    public function mount(): void
    {
        if ($this->record && ($this->record->latitud || $this->record->longitude)) {
            $this->data = [
                'location' => null,
                'lat' => $this->record->latitud ?? $this->getDefaultState()['lat'],
                'lng' => $this->record->longitude ?? $this->getDefaultState()['lng'],
                'address' => $this->record->gatuadress ?? null,
            ];
        } else {
            $this->data = [];
        }
    }

    public function form(Schema $schema): Schema
    {
        // Only show map when we have a record with coordinates
        if (! $this->record || (! $this->record->latitud && ! $this->record->longitude)) {
            return $schema->schema([]);
        }

        $defaults = config('filament-pinpoint.default');

        $lat = (float) ($defaults['lat'] ?? -0.5050);
        $lng = (float) ($defaults['lng'] ?? 117.1500);
        $label = $this->record ? ($this->record->gatuadress.' '.$this->record->postort) : null;

        return $schema
            ->schema([
                Pinpoint::make('location')
                    ->height(300)
                    ->label($label)
                    ->latField('lat')
                    ->lngField('lng')
                    ->addressField('address')
                    ->searchable(false)
                    ->defaultLocation($lat, $lng)
                    ->defaultZoom($defaults['zoom'] ?? 13)
                    ->height($defaults['height'] ?? 400)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->data ?? [];

        Notification::make()
            ->title('Coordinates captured')
            ->body(
                'Lat: '.($state['lat'] ?? '—').', Lng: '.($state['lng'] ?? '—'),
            )
            ->success()
            ->send();
    }

    public function resetForm(): void
    {
        $this->data = $this->getDefaultState();
    }

    protected function getDefaultState(): array
    {
        $defaults = config('filament-pinpoint.default');

        return [
            'location' => null,
            'lat' => $defaults['lat'] ?? -0.5050,
            'lng' => $defaults['lng'] ?? 117.1500,
            'address' => null,
        ];
    }
}
