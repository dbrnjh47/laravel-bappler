<?php

namespace App\Filament\Resources\ProxyResource\RelationManagers;

use App\Filament\Resources\BrowserGroupResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrowserProfilesRelationManager extends RelationManager
{
    protected static string $relationship = 'browser_profiles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Info')
                    // ->description('')
                    ->schema([
                        Forms\Components\TextInput::make('uuid')
                            ->label('UUID')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('serial_number')
                            ->required()
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('user_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('domain_name')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Connections')
                    // ->description('')
                    ->schema([
                        Forms\Components\Select::make('browser_group_id')
                            ->relationship(name: 'group', titleAttribute: 'name')
                            ->native(0)
                            ->searchable(['id', 'name', 'remark', 'uuid'])
                            ->preload(),


                    ])->columns(2),

                Forms\Components\Section::make('Date')
                    // ->description('')
                    ->schema([
                        Forms\Components\DateTimePicker::make('profil_created_at')->label('Profil create'),
                        Forms\Components\DateTimePicker::make('last_open_at')->label('Last open'),
                    ])->columns(2),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Info')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('uuid')->label('UUID'),
                        \Filament\Infolists\Components\TextEntry::make('serial_number'),
                        \Filament\Infolists\Components\TextEntry::make('name'),
                        \Filament\Infolists\Components\TextEntry::make('user_name'),
                        \Filament\Infolists\Components\TextEntry::make('domain_name'),
                    ])->columns(2),

                \Filament\Infolists\Components\Section::make('Connections')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('group.name')
                            ->url(fn($record): string => ($record->browser_group_id ? BrowserGroupResource::getUrl('view', ['record' => $record->browser_group_id]) : ''))
                            ->openUrlInNewTab()
                            ->color('primary')
                            ->label('Group'),
                    ])->columns(2),
                \Filament\Infolists\Components\Section::make('Connections')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('profil_created_at')->label('Profil create'),
                        \Filament\Infolists\Components\TextEntry::make('last_open_at')->label('Last open'),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID')
                    ->description(fn($record): string => ($record->serial_number ? $record->serial_number : ''))
                    ->searchable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->description(fn($record): string => ($record->group ? $record->group->uuid : ''))
                    ->label('Group')
                    ->url(fn($record): string => ($record->browser_group_id ? BrowserGroupResource::getUrl('view', ['record' => $record->browser_group_id]) : ''))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('domain_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('profil_created_at')
                    ->dateTime()
                    ->label('Profil create at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_open_at')
                    ->dateTime()
                    ->label('Last open at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('Group')
                    ->searchable()
                    ->preload()
                    ->relationship('group', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'),
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
}
