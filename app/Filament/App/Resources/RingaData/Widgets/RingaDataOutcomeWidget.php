<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData\Widgets;

use App\Enums\Outcomes;
use App\Models\RingaData;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

final class RingaDataOutcomeWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    public ?RingaData $record = null;

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-outcome-widget';

    protected int|string|array $columnSpan = '1/2';

    protected static ?string $heading = null;

    protected $listeners = ['record-selected' => 'updateRecord'];

    public function updateRecord(int $recordId): void
    {
        $this->record = RingaData::find($recordId);
    }

    public function selectOutcome(string $outcomeValue): void
    {
        if (! $this->record) {
            Notification::make()
                ->title('No record selected')
                ->body('Please select a record first.')
                ->warning()
                ->send();

            return;
        }

        $outcome = Outcomes::tryFrom($outcomeValue);
        if (! $outcome) {
            Notification::make()
                ->title('Invalid outcome')
                ->body('The selected outcome is not valid.')
                ->danger()
                ->send();

            return;
        }

        $this->record->update([
            'outcome' => $outcome->value,
            'is_outcome' => true,
            'attempts' => ($this->record->attempts ?? 0) + 1,
        ]);

        Notification::make()
            ->title('Outcome recorded')
            ->body("Recorded outcome: {$outcome->getLabel()}")
            ->icon($outcome->getIcon())
            ->color($outcome->getColor())
            ->send();

        // Refresh the record to update the display
        $this->record->refresh();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // The form will be handled in the Blade view with action buttons
            ])
            ->statePath('data');
    }
}
