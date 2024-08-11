<?php

namespace App\Livewire\App\User;

use App\Filament\Lecturer\Pages\App\Profile as ProfilePage;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class Profile extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $state = [];

    public $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->state = $this->user?->withoutRelations()->toArray();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            // Forms\Components\TextInput::make('login')
                // ->label('Username')
                // ->regex('/^[a-z0-9_-]{3,15}$/i')
                // ->unique(User::class, 'login', modifyRuleUsing: function (Unique $rule) {
                //     return $rule->whereNot('id', auth()->user()->id);
                // })
                // ->required()
                // ->disabledOn('edit'),

            Forms\Components\TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->unique(User::class, 'email', modifyRuleUsing: function (Unique $rule) {
                    return $rule->whereNot('id', auth()->user()->id);
                })
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255),
        ])->statePath('state');
    }

    public function save(): void
    {
        $this->resetErrorBag();
        $this->validate();


        $this->user->forceFill([
            // 'login' => $this->state['login'],
            'email' => $this->state['email'],
            'name' => $this->state['name'],
        ])->save();

        // if (isset($this->photo)) {
            redirect(ProfilePage::getUrl());
        // }

        Notification::make()->success()->title('Profile changed successfully.')->send();
    }
    public function render()
    {
        return view('livewire.app.user.profile');
    }
}
