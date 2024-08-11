<?php

namespace App\Filament\Lecturer\Resources\StudentResource\Pages;

use App\Filament\Lecturer\Resources\StudentResource;
use Filament\Actions;
// use Filament\Forms\Components\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }


    // tab filters work
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Level 100' => Tab::make()
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('enrollments', function (Builder $query) {
                $query->where('level', 100);
            })),
            'Level 200' => Tab::make()
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('enrollments', function (Builder $query) {
                $query->where('level', 200);
            })),
            'Level 300' => Tab::make()
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('enrollments', function (Builder $query) {
                $query->where('level', 300);
            })),
            'Level 400' => Tab::make()
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('enrollments', function (Builder $query) {
                $query->where('level', 400);
            })),

        ];
    }
}
