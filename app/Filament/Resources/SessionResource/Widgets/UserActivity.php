<?php

namespace App\Filament\Resources\SessionResource\Widgets;

use App\Models\Session;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UserActivity extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Session::query()
            )
            ->columns([
                TextColumn::make('user.name')->default('Anonymous'),
                TextColumn::make('ip_address'),
                TextColumn::make('last_activity')->dateTime(),
                TextColumn::make('user_agent'),
            ]);
    }
}
