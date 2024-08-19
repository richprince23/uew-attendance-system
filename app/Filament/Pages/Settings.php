<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('School Info')
            ->description('Update your school\'s information here')
                ->headerActions([
                    Action::make('edit')
                        ->action(function () {

                        }),
                ])->footerActions([
                    Action::make('save')->action(
                        function () {

                        }
                    )
                ])
                ->schema([
                    TextInput::make('school')->required()->maxLength(255)->default('University of Education, Winneba'),
                    TextInput::make('app_name')->maxLength(255)->default('Biometric Attendance System')->readOnly(),
                    TextInput::make('address')->required()->maxLength(255)->default('Winneba, Central Region, Ghana'),
                    TextInput::make('academic_year')->required()->maxLength(20)->default(2024),
                    Select::make('semester')->required()->options([
                        'first' => 'First Semester',
                        'second' => 'Second Semester',
                    ]),
                    DatePicker::make('semester_start')->required(),
                    DatePicker::make('semester_end')->required(),

                ])->columns(2)
        ]);
    }
}
