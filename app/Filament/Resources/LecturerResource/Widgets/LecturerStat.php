<?php

namespace App\Filament\Resources\LecturerResource\Widgets;

use App\Models\Lecturer;
use App\Models\Student;
use Filament\Forms\Components\Builder;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LecturerStat extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Lecturer::query()
            )
            ->columns([
                TextColumn::make('name')
            ]);
    }
}
