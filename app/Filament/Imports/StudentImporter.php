<?php

namespace App\Filament\Imports;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Artisan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Notifications\Notification;
use Log;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:80']),
            ImportColumn::make('index_number')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('level')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('department_id')
                ->requiredMapping()
                ->label('Department Name')
                ->rules(['required', 'string', 'max:255']),
            // ImportColumn::make('user_id')
            //     ->requiredMapping()
            //     ->numeric()->relationship(resolveUsing: 'email')
            //     ->rules(['required', 'integer']),
            ImportColumn::make('group')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:100']),
            ImportColumn::make('phone')
                ->rules(['max:20']),
        ];
    }

    public function resolveRecord(): ?Student
    {
        try {
            // Find existing student or create new one
            $student = Student::firstOrNew([
                'index_number' => $this->data['index_number'],
            ]);

         

            // Fill student data
            $student->fill([
                'name' => $this->data['name'],
                'index_number' => $this->data['index_number'],
                'level' => $this->data['level'],
                'gender' => $this->data['gender'],
                'department_id' => $this->data['department_id'],
                //logic is, when students are created, it automatically create a user account, and updates the student's user_id field, so user_id is not required
                // this is done in the creating boot medthod in the student model
                // 'user_id' => $user->id,
                'group' => $this->data['group'] ?? 'Group 1',
                'email' => $this->data['email'],
                'phone' => $this->data['phone'] ?? null,
            ]);

            $student->save();

            Log::info("Student imported successfully: {$student->name}");
            Notification::make("Imported student records")->title('Import Successfull')->success()->send();
            return $student;
        } catch (\Exception $e) {
            Log::error("Error importing student: " . $e->getMessage());
            return null;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
