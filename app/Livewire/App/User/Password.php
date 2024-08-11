<?php

namespace App\Livewire\App\User;

use App\Model\User;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component implements HasForms
{
    use InteractsWithForms;

    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('current_password')
                ->label('Current Password')
                ->password()
                ->rules(['current_password:web'])
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('New Password')
                ->password()
                // ->regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).*$/i')
                ->minLength(8)
                ->required()
                ->same('password_confirmation'),

            Forms\Components\TextInput::make('password_confirmation')
                ->label('Confirm New Password')
                ->password()
                // ->regex('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).*$/i')
                ->minLength(8)
                ->required()
                ->same('password'),
        ])->statePath('state');
    }

    public function save(): void
    {
        $this->resetErrorBag();
        $this->validate();

        if (session() !== null) {
            session()->put([
                'password_hash_'.Auth::getDefaultDriver() => Auth::user()?->getAuthPassword(),
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->forceFill(['password' => Hash::make($this->state['password'])])->save();

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        Notification::make()->success()->title('Password changed successfully.')->send();
    }

    public function getUserProperty(): ?Authenticatable
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.app.user.password');
    }
}
