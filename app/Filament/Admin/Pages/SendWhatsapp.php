<?php

namespace App\Filament\Admin\Pages;

use App\Services\RawWhatsappService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use UnitEnum;
use WallaceMartinss\FilamentEvolution\Exceptions\EvolutionApiException;
use WallaceMartinss\FilamentEvolution\Models\WhatsappInstance;

class SendWhatsapp extends Page
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static UnitEnum|string|null $navigationGroup = 'WhatsApp';

    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('instance_id')
                    ->label('WhatsApp Instance')
                    ->options(function () {
                        return WhatsappInstance::where('status', 'open')
                            ->get()
                            ->mapWithKeys(fn ($instance) => [
                                $instance->id => "{$instance->name} ({$instance->number})",
                            ]);
                    })
                    ->required()
                    ->placeholder('Select a WhatsApp instance'),

                TextInput::make('to_number')
                    ->label('To Number')
                    ->required()
                    ->placeholder('5511999999999')
                    ->helperText('Enter the phone number with country code (e.g., 5511999999999)'),

                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->rows(4)
                    ->placeholder('Enter your WhatsApp message here...'),
            ])
            ->statePath('data');
    }

    public function sendMessage(): void
    {
        $data = $this->form->getState();

        try {
            $service = app(RawWhatsappService::class);
            $response = $service->sendTextRaw(
                $data['instance_id'],
                (string) $data['to_number'],
                (string) $data['message']
            );

            Notification::make()
                ->title('Message Sent Successfully')
                ->body('Your WhatsApp message has been sent.')
                ->success()
                ->send();

            // Clear the form after successful send
            $this->form->fill();

        } catch (EvolutionApiException $e) {
            Notification::make()
                ->title('Failed to Send Message')
                ->body('Error: '.$e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendMessage')
                ->label('Send WhatsApp Message')
                ->action('sendMessage')
                ->icon('heroicon-o-paper-airplane')
                ->color('success'),
        ];
    }
}
