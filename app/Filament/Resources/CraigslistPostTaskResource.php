<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CraigslistPostTaskResource\Pages;
use App\Filament\Resources\CraigslistPostTaskResource\RelationManagers;
use App\Models\CraigslistPostTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CraigslistPostTaskResource extends Resource
{
    protected static ?string $model = CraigslistPostTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('scheduled_start_date')
                    ->required(),
                Forms\Components\DatePicker::make('scheduled_end_date')
                    ->required(),
                Forms\Components\TextInput::make('start_time')
                    ->required(),
                Forms\Components\TextInput::make('end_time')
                    ->required(),
                Forms\Components\TextInput::make('posts_quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('schedule_type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
                Tables\Columns\TextColumn::make('posts_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule_type'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCraigslistPostTasks::route('/'),
            // 'create' => Pages\CreateCraigslistPostTask::route('/create'),
            'view' => Pages\ViewCraigslistPostTask::route('/{record}'),
            // 'edit' => Pages\EditCraigslistPostTask::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Отключить навигацию
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
