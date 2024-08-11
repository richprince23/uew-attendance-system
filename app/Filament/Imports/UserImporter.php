<?php

namespace App\Filament\Imports;

use App\Models\User;
use Artisan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            // ImportColumn::make('email_verified_at')
            //     ->rules(['email', 'datetime']),
            // ImportColumn::make('password')
            //     ->requiredMapping()
            //     ->rules(['required', 'max:255']),
            // ImportColumn::make('role')
            //     ->requiredMapping()
            //     ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?User
    {
        // return User::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        // return new User();


        $user = User::firstOrNew([
            'email' => $this->data['email'],  // Match by email
        ]);

        // Update the user with the imported data
        $user->fill([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);

        // Save the user record to the database
        $user->save();

        // Artisan::call('queue:work', [
        //     '--sleep' => 3,
        //     '--tries' => 3,
        //     '--timeout' => 90,
        // ]);

        return $user;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
