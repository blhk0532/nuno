<?php

namespace App\Filament\Widgets;

use App\Models\CalendarSettings;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

final class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = 'App\Models\CalendarEvent';

    protected static ?int $sort = 1;

    protected static ?string $title = 'calendar';

    protected static string $viewIdentifier = 'calendar-widget';

    protected int|string|array $columnSpan = 'full';

    public function config(): array
    {
        $settings = CalendarSettings::where('user_id', Auth::id())->first();

        $openingStart = $settings?->opening_hour_start?->format('H:i:s') ?? '09:00:00';
        $openingEnd = $settings?->opening_hour_end?->format('H:i:s') ?? '17:00:00';

        $config = [
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'nowIndicator' => true,
            'views' => [
                'timeGridDay' => [
                    'slotMinTime' => $openingStart,
                    'slotMaxTime' => $openingEnd,
                    'slotHeight' => 60,
                ],
                'timeGridWeek' => [
                    'slotMinTime' => $openingStart,
                    'slotMaxTime' => $openingEnd,
                    'slotHeight' => 60,
                ],
            ],
        ];

        return $config;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label('Title'),

            Textarea::make('description')
                ->rows(3)
                ->label('Description')
                ->columnSpanFull(),

            DateTimePicker::make('start')
                ->required()
                ->native(false)
                ->seconds(false)
                ->label('Start Date & Time'),

            DateTimePicker::make('end')
                ->required()
                ->native(false)
                ->seconds(false)
                ->label('End Date & Time')
                ->rule('after:start'),

            Checkbox::make('all_day')
                ->label('All Day Event'),
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(function ($form, array $arguments) {
                    if ($form !== null) {
                        $form->fill([
                            'start' => $arguments['start'] ?? null,
                            'end' => $arguments['end'] ?? null,
                            'all_day' => $arguments['allDay'] ?? false,
                        ]);
                    }
                })
                ->mutateFormDataUsing(function (array $data): array {
                    // Set user_id to current user
                    $data['user_id'] = Auth::user()?->id;

                    return $data;
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // Ensure user_id is preserved
                    if (! isset($data['user_id'])) {
                        $data['user_id'] = Auth::user()?->id;
                    }

                    return $data;
                }),
        ];
    }
}
