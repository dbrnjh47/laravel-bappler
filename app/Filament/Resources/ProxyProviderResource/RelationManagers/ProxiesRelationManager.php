<?php

namespace App\Filament\Resources\ProxyProviderResource\RelationManagers;

use App\Filament\Resources\ProxyProviderResource;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProxiesRelationManager extends RelationManager
{
    protected static string $relationship = 'proxies';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Proxy')
                        ->schema([
                            Forms\Components\Toggle::make('status')
                                ->onColor('success')
                                ->offColor('danger')
                                ->required(),

                            Forms\Components\Section::make('Info')
                                // ->description('')
                                ->schema([
                                    Forms\Components\Select::make('proxy_provider_id')
                                        ->relationship(name: 'provider', titleAttribute: 'login')
                                        ->native(0)
                                        ->searchable(['id', 'name', 'login', 'email'])
                                        ->preload()
                                        ->required(),
                                    Forms\Components\TextInput::make('uuid')
                                        ->label('UUID')
                                        ->required()
                                        ->maxLength(255),

                                ])->columns(2),

                            Forms\Components\Section::make('Type')
                                // ->description('')
                                ->schema([
                                    Forms\Components\TextInput::make('network_type')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('proxy_type')
                                        ->required()
                                        ->maxLength(255),
                                ])->columns(2),
                            Forms\Components\Section::make('Auth')
                                // ->description('')
                                ->schema([
                                    Forms\Components\TextInput::make('username')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('password')
                                        ->password()
                                        ->maxLength(255),
                                ])->columns(2),

                            Forms\Components\Section::make('Date')
                                // ->description('')
                                ->schema([
                                    Forms\Components\DateTimePicker::make('expires_at')
                                        ->label('Stop'),
                                    Forms\Components\DateTimePicker::make('provider_created_at')
                                        ->label('Create in provider'),
                                ])->columns(2),
                        ]),
                    Forms\Components\Wizard\Step::make('Connection')
                        ->schema([
                            Forms\Components\Fieldset::make('connection')
                                ->relationship('connection')
                                ->schema([
                                    Forms\Components\Section::make('IP')
                                        // ->description('')

                                        ->schema([
                                            Forms\Components\TextInput::make('public_ip')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('connect_ip')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('ip_version')
                                                ->required()
                                                ->maxLength(255),
                                        ])->columns(3),
                                    Forms\Components\Section::make('Port')

                                        // ->description('')
                                        ->schema([
                                            Forms\Components\TextInput::make('http_port')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('https_port')
                                                ->maxLength(255),
                                            Forms\Components\TextInput::make('socks_5_port')
                                                ->maxLength(255),
                                        ])->columns(3),
                                ])
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            \Filament\Infolists\Components\Tabs::make('Tabs')->tabs([
                \Filament\Infolists\Components\Tabs\Tab::make('Proxy')
                    ->schema([
                        // Forms\Components\Toggle::make('status')
                        //     ->required(),
                        \Filament\Infolists\Components\IconEntry::make('status')->boolean(),

                        \Filament\Infolists\Components\Section::make('Info')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('provider.login')
                                    ->url(fn ($record): string => ProxyProviderResource::getUrl('view', ['record' => $record->proxy_provider_id]))
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->label('Provider'),
                                \Filament\Infolists\Components\TextEntry::make('uuid')
                                    ->label('UUID'),

                            ])->columns(2),

                        \Filament\Infolists\Components\Section::make('Type')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('network_type'),
                                \Filament\Infolists\Components\TextEntry::make('proxy_type'),
                            ])->columns(2),
                        \Filament\Infolists\Components\Section::make('Auth')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('username')->copyable()->color('primary'),
                                \Filament\Infolists\Components\TextEntry::make('password')->copyable()->color('primary'),
                            ])->columns(2),

                        \Filament\Infolists\Components\Section::make('Date')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('expires_at')
                                    ->label('Stop'),
                                \Filament\Infolists\Components\TextEntry::make('provider_created_at')
                                    ->label('Create in provider'),

                            ])->columns(2),
                    ]),
                \Filament\Infolists\Components\Tabs\Tab::make('Connection')
                    ->schema([
                        \Filament\Infolists\Components\Section::make('IP')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('connection.public_ip')
                                ->label('Public IP'),
                                \Filament\Infolists\Components\TextEntry::make('connection.connect_ip')
                                ->label('Connect IP'),
                                \Filament\Infolists\Components\TextEntry::make('connection.ip_version')
                                ->label('IP version'),
                            ])->columns(3),
                        \Filament\Infolists\Components\Section::make('Port')
                            // ->description('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('connection.http_port')
                                ->label('Http port'),
                                \Filament\Infolists\Components\TextEntry::make('connection.https_port')
                                ->label('Https port'),
                                \Filament\Infolists\Components\TextEntry::make('connection.socks_5_port')
                                ->label('Socks5 port'),
                            ])->columns(3),

                    ]),
            ])->columnSpanFull()
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('uuid')
                ->label('UUID')
                ->searchable(),
            Tables\Columns\IconColumn::make('status')
                ->sortable()
                ->boolean(),
            Tables\Columns\TextColumn::make('network_type')
                ->searchable(),
            Tables\Columns\TextColumn::make('username')
                ->searchable(),
            Tables\Columns\TextColumn::make('proxy_type')
                ->searchable(),
            Tables\Columns\TextColumn::make('connection.public_ip')
                ->label('Public ip')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('connection.connect_ip')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('expires_at')
                ->label('Stop at')
                ->dateTime()->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('provider_created_at')
                ->label('Create in provider at')
                ->dateTime()->toggleable(isToggledHiddenByDefault: true)
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
            \Filament\Tables\Filters\Filter::make('Activ')
                    ->query(fn (Builder $query): Builder => $query->where('status', true)),
            \Filament\Tables\Filters\Filter::make('No activ')
                    ->query(fn (Builder $query): Builder => $query->where('status', false)),

            \Filament\Tables\Filters\SelectFilter::make('Browser profile')
            ->searchable()
            ->preload()
            ->relationship('browser_profiles', 'name'),
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
}
