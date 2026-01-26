<?php

namespace App\Livewire;

use Filament\Forms;
use App\Enums\UserActiveStatus;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;

class CustomProfileComponent extends Component implements HasSchemas
{
    use InteractsWithSchemas;
    use HasSort;

    public ?array $data = [];

    protected static int $sort = 0;

    public function mount(): void
    {
        $this->form->fill([
            'active_status' => Auth::user()->active_status,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Din Status')
                    ->aside()
                    ->hidden()
                    ->description('Uppdatera din synliga aktivitetsstatus.')
                    ->schema([
                        Select::make('active_status')
                            ->label('Status')
                            ->options(UserActiveStatus::class)
                            ->native(false)
                            ->selectablePlaceholder(false),
                    ]),
            ])
            ->statePath('data');
    }



    public function render(): View
    {
        return view('livewire.custom-profile-component');
    }
}
