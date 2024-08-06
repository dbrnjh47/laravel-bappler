<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NamecheapAccountResource\Pages;
use App\Filament\Resources\NamecheapAccountResource\RelationManagers;
use App\Models\NamecheapAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NamecheapAccountResource extends Resource
{
    protected static ?string $model = NamecheapAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'IT';

    protected static ?int $navigationSort = 20;

    protected static ?string $modelLabel = 'Domain registrar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label('Account Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apikey')
                    ->label('API Key')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->label('Account Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apikey')
                    ->label('API Key'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->hidden(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListNamecheapAccounts::route('/'),
            'create' => Pages\CreateNamecheapAccount::route('/create'),
            'edit' => Pages\EditNamecheapAccount::route('/{record}/edit'),
        ];
    }
}
