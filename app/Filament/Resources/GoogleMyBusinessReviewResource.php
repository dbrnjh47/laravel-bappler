<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleMyBusinessReviewResource\Pages;
use App\Filament\Resources\GoogleMyBusinessReviewResource\RelationManagers;
use App\Models\GoogleMyBusinessReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GoogleMyBusinessReviewResource extends Resource
{
    protected static ?string $model = GoogleMyBusinessReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'CRM';
    protected static ?int $navigationSort = 101;

    protected static ?string $modelLabel = 'Review';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('google_my_business_point_id')
                    ->relationship('google_account', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('User Name')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('stars')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('text')
                    ->label('Review Text')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->rows(10),
                /*
                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    //->disk('local')
                    ->directory('images'),
                */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('google_account.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stars')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->label('Published Date')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('text')
                    ->limit(50),
                /*
                Tables\Columns\ImageColumn::make('images')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(),
                */
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
            'index' => Pages\ListGoogleMyBusinessReviews::route('/'),
            'create' => Pages\CreateGoogleMyBusinessReview::route('/create'),
            'edit' => Pages\EditGoogleMyBusinessReview::route('/{record}/edit'),
        ];
    }
}
