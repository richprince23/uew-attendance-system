<?php

namespace App\Filament\Imports;

use App\Models\Student;
use App\Models\User;
use Artisan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

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
            ImportColumn::make('user_id')
                ->requiredMapping()
                ->numeric()->relationship(resolveUsing: 'email')
                ->rules(['required', 'integer']),
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

            // Find the user by email
            $user = User::where('email', $this->data['email'])->first();
            if (!$user) {
                Log::warning("User not found for email: {$this->data['email']}");
                return null;
            }

            // Find the department by name (assuming 'department' is the name field)
            $department = Department::where('name', $this->data['department_id'])->first();
            if (!$department) {
                Log::warning("Department not found: {$this->data['department_id']}");
                return null;
            }

            // Fill student data
            $student->fill([
                'name' => $this->data['name'],
                'index_number' => $this->data['index_number'],
                'level' => $this->data['level'],
                'gender' => $this->data['gender'],
                'department_id' => $department->id,
                'user_id' => $user->id,
                'group' => $this->data['group'] ?? null,
                'email' => $this->data['email'],
                'phone' => $this->data['phone'] ?? null,
            ]);

            $student->save();

            Log::info("Student imported successfully: {$student->name}");

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
