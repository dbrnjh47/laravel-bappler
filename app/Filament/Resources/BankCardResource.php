<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankCardResource\Pages;
use App\Filament\Resources\BankCardResource\RelationManagers;
use App\Models\BankCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankCardResource extends Resource
{
    protected static ?string $model = BankCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 61;

    protected static ?string $navigationGroup = 'IT';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('card_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('expiration')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cvc')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status'),
                Forms\Components\TextInput::make('billing_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('lInks_accounts')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('card_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expiration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cvc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                // Tables\Columns\TextColumn::make('billing_address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('lInks_accounts')
                //     ->searchable(),
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListBankCards::route('/'),
            'create' => Pages\CreateBankCard::route('/create'),
            'view' => Pages\ViewBankCard::route('/{record}'),
            'edit' => Pages\EditBankCard::route('/{record}/edit'),
        ];
    }
}
