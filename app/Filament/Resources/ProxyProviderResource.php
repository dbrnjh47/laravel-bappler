<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProxyProviderResource\Pages;
use App\Filament\Resources\ProxyProviderResource\RelationManagers;
use App\Filament\Resources\ProxyProviderResource\RelationManagers\ProxiesRelationManager;
use App\Models\ProxyProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\View\Components\Modal;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxyProviderResource extends Resource
{
    protected static ?string $model = ProxyProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    // protected static ?string $navigationLabel = 'Proxy Provider';
    protected static ?string $modelLabel = 'Proxy Provider';

    protected static ?string $navigationGroup = 'IT';

    protected static ?int $navigationSort = 41;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Info')
                    // ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('login')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('name')
                            ->options([
                                'proxy_cheap' => 'Proxy Cheap',
                            ])
                            ->native(0)
                            ->required(),
                        // Forms\Components\TextInput::make('balance')
                        //     ->required()
                        //     ->numeric()
                        //     ->default(0.00),
                    ])->columns(3),

                Forms\Components\Section::make('API')
                    // ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('api_key')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('secret_key')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // TextEntry::make('proxies_count')
                //     ->label('Count Proxy')
                //     ->state(function (Model $record): int {
                //         return $record->proxies()->count();
                //     }),

                 Section::make('Info')
                    // ->description('')
                    ->schema([
                        TextEntry::make('login'),
                        TextEntry::make('email'),
                        TextEntry::make('name'),
                        // TextEntry::make('balance')->money('USD'),
                    ])->columns(3),

                Section::make('API')
                    // ->description('')
                    ->schema([
                        TextEntry::make('api_key'),
                        TextEntry::make('secret_key'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('login')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->money("USD")
                    ->sortable(),
                Tables\Columns\TextColumn::make("proxies_count")->counts('proxies'),
                Tables\Columns\TextColumn::make('api_key')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('secret_key')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
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
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
                // Tables\Actions\Action::make('copyToSelected')
                // ->accessSelectedRecords()
                // ,
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
            ProxiesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProxyProviders::route('/'),
            'create' => Pages\CreateProxyProvider::route('/create'),
            'view' => Pages\ViewProxyProvider::route('/{record}'),
            'edit' => Pages\EditProxyProvider::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::first()->balance."$";
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return (static::getModel()::first()->balance < 100 ? "danger": "info");
    }
}
