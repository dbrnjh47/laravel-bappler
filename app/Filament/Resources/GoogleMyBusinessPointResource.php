<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleMyBusinessPointResource\Pages;
use App\Filament\Resources\GoogleMyBusinessPointResource\RelationManagers;
use App\Models\GoogleMyBusinessPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GoogleMyBusinessPointResource extends Resource
{
    protected static ?string $model = GoogleMyBusinessPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?int $navigationSort = 47;

    protected static ?string $modelLabel = 'Account';

    protected static ?string $navigationLabel = 'GMB Accounts Map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('domain_id')
                    ->relationship('domain', 'namecheap_domain_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('email_id')
                    ->relationship('email', 'email')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->maxLength(500),
                Forms\Components\TextInput::make('open_hours')
                    ->required()
                    ->maxLength(255)
                    ->label('Open Hours'),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('adspower_profile_id')
                    ->required()
                    ->maxLength(30)
                    ->label('AdsPower Profile User ID'),
                Forms\Components\TextInput::make('organization_google_maps_url')
                    ->required()
                    ->maxLength(1000)
                    ->label('Organization Google Maps URL'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('domain.namecheap_domain_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email.email')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('open_hours')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adspower_profile_id')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
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
            'index' => Pages\ListGoogleMyBusinessPoints::route('/'),
            'create' => Pages\CreateGoogleMyBusinessPoint::route('/create'),
            'edit' => Pages\EditGoogleMyBusinessPoint::route('/{record}/edit'),
        ];
    }
}
