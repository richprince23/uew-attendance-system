<?php

namespace App\Filament\Resources\LecturerResource\Pages;

use App\Filament\Resources\LecturerResource;
use App\Models\Lecturer;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Hash;

class CreateLecturer extends CreateRecord
{
    protected static string $resource = LecturerResource::class;

    // public static function afterCreate(Lecturer $lecturer): void
    // {
    //     // $password = Str::random(10);

    //     $user = User::create([
    //         'name' => $lecturer->name,
    //         'email' => $lecturer->email,
    //         'password' => Hash::make('lecturer'),
    //         'role' => 'lecturer', // Assuming you have a role field
    //     ]);
    // }
}
