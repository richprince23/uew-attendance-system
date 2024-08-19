<?php

namespace App\Filament\Pages;


use App\Models\Settings as Setting;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;


class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    public $data;
    public $isEditing = false;

    public function mount()
    {
        $settings = Setting::first() ?? new Setting();
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('School Info')
                ->description('Update your school\'s information here')
                ->headerActions([
                    Action::make('edit')
                        ->label(fn () => $this->isEditing ? 'Cancel' : 'Edit')
                        ->action(function () {
                            $this->isEditing = !$this->isEditing;
                        }),
                ])
                ->footerActions([
                    Action::make('save')
                        ->action('save')
                        ->visible(fn () => $this->isEditing)
                ])
                ->schema([
                    TextInput::make('school')
                        ->required()
                        ->maxLength(255)
                        ->default('University of Education, Winneba')
                        ->disabled(fn () => !$this->isEditing),
                    TextInput::make('app_name')
                        ->maxLength(255)
                        ->default('Biometric Attendance System')
                        ->disabled(),
                    TextInput::make('address')
                        ->required()
                        ->maxLength(255)
                        ->default('Winneba, Central Region, Ghana')
                        ->disabled(fn () => !$this->isEditing),
                    TextInput::make('academic_year')
                        ->required()
                        ->maxLength(20)
                        ->default(date('Y'))
                        ->disabled(fn () => !$this->isEditing),
                    Select::make('semester')
                        ->required()
                        ->options([
                            'first' => 'First Semester',
                            'second' => 'Second Semester',
                        ])
                        ->disabled(fn () => !$this->isEditing),
                    DatePicker::make('semester_start')
                        ->required()
                        ->disabled(fn () => !$this->isEditing),
                    DatePicker::make('semester_end')
                        ->required()
                        ->disabled(fn () => !$this->isEditing),
                ])
                ->columns(2)
        ])->statePath('data');
    }

    // public function save()
    // {
    //     $this->validate();

    //     $this->data->save();

    //     $this->isEditing = false;

    //     Notification::make()
    //         ->title('Settings saved successfully')
    //         ->success()
    //         ->send();
    // }

    public function save()
        {
            $data = $this->form->getState();

            $setting = Setting::first() ?? new Setting();
            $setting->fill($data);
            $setting->save();

            $this->isEditing = false;

            Notification::make()
                ->title('Settings saved successfully')
                ->success()
                ->send();
        }
}









// class Settings extends Page implements HasForms
// {
//     use InteractsWithForms;

//     protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
//     protected static string $view = 'filament.pages.settings';

//     protected static bool $shouldRegisterNavigation = true;

//     public $data;
//     public $isEditing = false;

//     public function mount()
//     {
//         $settings = Setting::first() ?? new Setting();
//         $this->form->fill($settings->toArray());
//     }

//     public function form(Form $form): Form
//     {
//         return $form->schema([
//             Section::make('School Info')
//                 ->description('Update your school\'s information here')
//                 ->headerActions([
//                     Action::make('edit')
//                         ->label(fn () => $this->isEditing ? 'Cancel' : 'Edit')
//                         ->action(function () {
//                             $this->isEditing = !$this->isEditing;
//                         }),
//                 ])
//                 ->footerActions([
//                     Action::make('save')
//                         ->action('save')
//                         ->visible(fn () => $this->isEditing)
//                 ])
//                 ->schema([
//                     TextInput::make('school')
//                         ->required()
//                         ->maxLength(255)
//                         ->disabled(fn () => !$this->isEditing),
//                     TextInput::make('app_name')
//                         ->maxLength(255)
//                         ->disabled(),
//                     TextInput::make('address')
//                         ->required()
//                         ->maxLength(255)
//                         ->disabled(fn () => !$this->isEditing),
//                     TextInput::make('academic_year')
//                         ->required()
//                         ->maxLength(20)
//                         ->disabled(fn () => !$this->isEditing),
//                     Select::make('semester')
//                         ->required()
//                         ->options([
//                             'first' => 'First Semester',
//                             'second' => 'Second Semester',
//                         ])
//                         ->disabled(fn () => !$this->isEditing),
//                     DatePicker::make('semester_start')
//                         ->required()
//                         ->disabled(fn () => !$this->isEditing),
//                     DatePicker::make('semester_end')
//                         ->required()
//                         ->disabled(fn () => !$this->isEditing),
//                 ])
//                 ->columns(2)
//         ]);
//     }

//
// }
