<?php

namespace App\Filament\App\Resources\RingaData\Tables;

use App\Models\RingaData;
use Faker\Factory as Faker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Pages\ListRecords;
use Shreejan\ActionableColumn\Tables\Columns\ActionableColumn;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;


class RingaDataTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->toolbarActions([
                \EightyNine\ExcelImport\ExcelImportAction::make()
                    ->color("primary"),
                Actions\CreateAction::make(),
            ])
            ->headerActions([

                // Actions\CreateAction::make()
                //         ->label("+"),
                //    static::generateFakeDataAction()
                //    ->label(""),

            ])
            ->columns([

                TextColumn::make('personnamn')
                    ->searchable()
                    ->sortable(),
                                    TextColumn::make('fodelsedag')
                    ->label('Age')
                    ->state(fn(RingaData $record) => $record->fodelsedag ? \Carbon\Carbon::parse($record->fodelsedag)->age : '-')
                    ->sortable(),
                TextColumn::make('gatuadress')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('postnummer')
                ->label('postnr')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('postort')
                    ->searchable()
                    ->sortable(),



                CopyableTextColumn::make('telefon')
                    ->searchable()
                        ->sortable(),
                                    TextColumn::make('attempts')
                    ->label('Try')
                    ->sortable()
                       ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                                   TextColumn::make('outcome')
                                    ->label('🕻')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => null),

                     ActionableColumn::make('status')
                    ->badge()
                        ->sortable()
                      ->toggleable(false)
                        ->label('🛈')                                  // Display as badge (or remove for simple text)
                    ->color('success')                           // Badge/text color: success, danger, warning, info, primary
                    ->actionIcon(Heroicon::Clock)         // Action button icon (Heroicon enum or string)
                    ->actionIconColor('warning')                 // Icon color (independent from badge color)
                    ->clickableColumn()                          // Make entire column clickable (or remove for button-only)
                    ->tapAction(
                        Action::make('changeStatus')              // Any Filament Action: edit, delete, approve, etc.
                            ->label('Change Status')
                            ->tooltip('Click to change status')
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'disabled' => 'Disabled',
                                         '⊘' => 'Quarantine',
                                    ])
                                    ->required(),
                            ])
                            ->fillForm(fn($record) => [
                                'status' => $record->status,
                            ])
                            ->action(function ($record, array $data) {
                                $record->update($data);
                            })
                    ),



                TextColumn::make('expires_at')
                    ->dateTime()
                    ->hidden()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->hidden()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('fodelsedag')
                    ->form([
                        DatePicker::make('fodelsedag_min')
                            ->label('Min födelsedag'),
                        DatePicker::make('fodelsedag_max')
                            ->label('Max födelsedag'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['fodelsedag_min'] ?? null,
                                fn($q, $date) => $q->whereDate('fodelsedag', '>=', $date),
                            )
                            ->when(
                                $data['fodelsedag_max'] ?? null,
                                fn($q, $date) => $q->whereDate('fodelsedag', '<=', $date),
                            );
                    }),
                Filter::make('postnummer')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('postnummer')
                            ->label('Postnummer'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['postnummer'] ?? null,
                            fn($q, $postnummer) => $q->where('postnummer', 'like', '%' . $postnummer . '%'),
                        );
                    }),
                SelectFilter::make('outcome')
                    ->label('Outcome'),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('view_details')
                    ->label('')
                    ->icon('heroicon-o-phone-arrow-up-right')
                    ->color('primary')
                    ->url(fn(RingaData $record) => 'tel:' . $record->telefon),
                EditAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('assignToUsers')
                        ->label('Tilldela till användare')
                        ->icon('heroicon-o-users')
                        ->form([
                            Select::make('users')
                                ->label('Välj användare')
                                ->multiple()
                                ->searchable()
                                ->options(User::all()->pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $userIds = implode(',', $data['users']);
                            foreach ($records as $record) {
                                $record->update(['user_id' => $userIds]);
                            }

                            Notification::make()
                                ->title('Användare tilldelade')
                                ->success()
                                ->send();
                        })
                        ->visible(fn() => in_array(auth()->user()->role, ['admin', 'super', 'super_admin', 'superadmin', 'manager'])),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
        ];
    }

    private static function generateFakeDataAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('generateFakeData')
            ->label('Generate Fake Data')
            ->icon('heroicon-o-sparkles')
            ->color('warning')
            ->form([
                TextInput::make('count')
                    ->label('Number of records')
                    ->numeric()
                    ->required()
                    ->default(10)
                    ->minValue(1)
                    ->maxValue(500)
                    ->helperText('Generate between 1 and 500 fake records'),
            ])
            ->requiresConfirmation()
            ->modalHeading('Generate Fake RingaData Records')
            ->modalDescription('This will create fake RingaData records for testing purposes.')
            ->modalSubmitActionLabel('Generate')
            ->action(function (array $data): void {
                $count = $data['count'] ?? 10;
                $faker = Faker::create('sv_SE');

                $created = 0;
                for ($i = 0; $i < $count; $i++) {
                    RingaData::create([
                        'gatuadress' => $faker->streetAddress(),
                        'postnummer' => $faker->postcode(),
                        'postort' => $faker->city(),
                        'forsamling' => $faker->word(),
                        'kommun' => $faker->city(),
                        'kommun_ratsit' => $faker->city(),
                        'lan' => $faker->randomElement(['Västra Götaland', 'Stockholms', 'Skåne', 'Örebro', 'Värmland', 'Dalarna', 'Gävleborg', 'Västernorrland', 'Jämtland', 'Norrbotten']),
                        'adressandring' => $faker->optional()->text(100),
                        'telfonnummer' => [$faker->phoneNumber(), $faker->optional()->phoneNumber()],
                        'stjarntacken' => $faker->optional()->word(),
                        'fodelsedag' => $faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d'),
                        'personnummer' => $faker->numerify('##########'),
                        'alder' => $faker->numberBetween(18, 100),
                        'kon' => $faker->randomElement(['M', 'K']),
                        'civilstand' => $faker->randomElement(['ogift', 'gift', 'skild', 'änka']),
                        'fornamn' => $faker->firstName(),
                        'efternamn' => $faker->lastName(),
                        'personnamn' => $faker->name(),
                        'telefon' => $faker->phoneNumber(),
                        'epost_adress' => [$faker->email(), $faker->optional()->email()],
                        'agandeform' => $faker->randomElement(['ägo', 'hyres', 'andels']),
                        'bostadstyp' => $faker->randomElement(['villa', 'lägenhet', 'radhus']),
                        'boarea' => $faker->numberBetween(30, 200),
                        'byggar' => $faker->year(),
                        'fastighet' => $faker->word(),
                        'personer' => [$faker->firstName(), $faker->optional()->firstName()],
                        'foretag' => [$faker->optional()->company()],
                        'grannar' => [$faker->firstName(), $faker->optional()->firstName()],
                        'fordon' => [$faker->optional()->word()],
                        'hundar' => [$faker->optional()->word()],
                        'bolagsengagemang' => [$faker->optional()->company()],
                        'longitude' => $faker->longitude(),
                        'latitud' => $faker->latitude(),
                        'google_maps' => $faker->url(),
                        'google_streetview' => $faker->url(),
                        'ratsit_se' => $faker->url(),
                        'is_active' => $faker->boolean(80),
                        'is_hus' => $faker->boolean(50),
                        'is_telefon' => $faker->boolean(70),
                        'is_queued' => $faker->boolean(20),
                        'started_at' => $faker->dateTimeThisYear(),
                        'expires_at' => $faker->dateTimeBetween('now', '+1 year'),
                    ]);
                    $created++;
                }

                Notification::make()
                    ->success()
                    ->title('Fake data generated')
                    ->body("Successfully created {$created} fake RingaData records.")
                    ->send();
            });
    }
}
