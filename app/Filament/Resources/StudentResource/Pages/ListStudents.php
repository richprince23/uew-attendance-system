<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Imports\StudentImporter;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(StudentImporter::class)
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'Level 100' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 100)),
            'Level 200' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 200)),
            'Level 300' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 300)),
            'Level 400' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 400)),
            'Males' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'male')),
            'Females' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('gender', 'female')),
        ];
    }
}
