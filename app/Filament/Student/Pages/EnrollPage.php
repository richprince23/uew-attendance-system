<?php

namespace App\Filament\Student\Pages;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class EnrollPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static string $view = 'filament.student.pages.enroll-page';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                // Department Selector
                // Select::make('department_id')
                //     ->label('Department')
                //     ->options(\App\Models\Department::all()->pluck('name', 'id'))
                //     ->reactive()
                //     ->afterStateUpdated(fn($state, callable $set) => $set('courses', null)),

                // Level Selector
                Select::make('level')
                    ->label('Level')
                    ->options([
                        '100' => 'Level 100',
                        '200' => 'Level 200',
                        '300' => 'Level 300',
                        '400' => 'Level 400',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('courses', null)),

                // Year Selector
                Select::make('year')
                    ->label('Year')
                    // ->options([
                    //     '2021' => '2021',
                    //     '2022' => '2022',
                    //     '2023' => '2023',
                    //     '2024' => '2024',
                    // ])
                    ->relationship('course', 'year'),
                    // ->reactive()
                    // ->afterStateUpdated(fn($state, callable $set) => $set('courses', null)),

                // Semester Selector
                Select::make('semester')
                    ->label('Semester')
                    ->options([
                        'first' => 'First Semester',
                        'second' => 'Second Semester',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('courses', null)),

                // Courses Checkbox List
                CheckboxList::make('courses')
                    ->label('Courses')
                    ->options(function (callable $get) {
                        $departmentId = $get('department_id');
                        $level = $get('level');
                        $year = $get('year');
                        $semester = $get('semester');

                        // Debug logs
                        Log::info('Fetching courses for department: ' . $departmentId . ', level: ' . $level . ', year: ' . $year . ', semester: ' . $semester);

                        return Course::when($departmentId, function ($query, $departmentId) {
                            return $query->where('department_id', $departmentId);
                        })
                            ->when($level, function ($query, $level) {
                                return $query->where('level', $level);
                            })
                            ->when($year, function ($query, $year) {
                                return $query->where('year', $year);
                            })
                            ->when($semester, function ($query, $semester) {
                                return $query->where('semester', $semester);
                            })
                            ->pluck('course_name', 'id');
                    })
                    ->required(),
            ]);
    }

    public function save(): void
    {
        $student = Student::where('user_id', auth()->id())->get()->first();
        $studentId = $student->user_id;


        $data = $this->form->getState();

        // Assuming the user is authenticated
        $user = auth()->user();

        // Save selected course IDs to the enrollments
        foreach ($data['courses'] as $courseId) {
            Enrollment::create([
                'student_id' => $studentId,
                'course_id' => $courseId,
            ]);
        }

        $this->notify('success', 'Enrollment saved successfully!');
    }
}
