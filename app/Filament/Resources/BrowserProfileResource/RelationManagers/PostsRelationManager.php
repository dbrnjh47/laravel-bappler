<?php

namespace App\Filament\Resources\BrowserProfileResource\RelationManagers;

use App\Filament\Resources\BrowserProfileResource;
use App\Http\Controllers\Craigslist\CraigslistController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Info')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\ViewEntry::make('title')->view('tables.columns.craig-list.title-and-preview')->columnSpanFull(),
                        \Filament\Infolists\Components\TextEntry::make('uuid')->label('UUID'),

                        \Filament\Infolists\Components\TextEntry::make('browser_profile.name')
                                    ->url(fn ($record): string => ($record->browser_profile ? BrowserProfileResource::getUrl('view', ['record' => $record->browser_profile]) : ''))
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->label('Browser profile'),
                        \Filament\Infolists\Components\TextEntry::make('last_posted_at')->columnSpanFull(),

                        \Filament\Infolists\Components\TextEntry::make('city'),
                        \Filament\Infolists\Components\TextEntry::make('zip'),
                        \Filament\Infolists\Components\TextEntry::make('description')->columnSpanFull(),
                    ])->columns(2),

                \Filament\Infolists\Components\Section::make('Phone/text')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('phone_number'),
                        \Filament\Infolists\Components\TextEntry::make('name'),
                        \Filament\Infolists\Components\TextEntry::make('extension'),

                        \Filament\Infolists\Components\IconEntry::make('show_phone')
                            ->label("Show my phone number")
                            ->boolean(),
                        \Filament\Infolists\Components\IconEntry::make('phone_calld')
                            ->label("Phone calls")
                            ->boolean(),
                        \Filament\Infolists\Components\IconEntry::make('text_ok')
                            ->label("Text/sms")
                            ->boolean(),

                    ])->columns(3),

                \Filament\Infolists\Components\Section::make('Phone/text')
                    // ->description('')
                    ->schema([


                        \Filament\Infolists\Components\TextEntry::make('email_privacy')
                            ->badge()
                            ->label("Email privacy options")
                            ->color('warning')
                    ])->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([

            ])
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),

                Tables\Columns\ViewColumn::make('title')
                    ->view('tables.columns.craig-list.title-and-preview')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('city')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),

                Tables\Columns\TextColumn::make('last_posted_at')
                    ->dateTime()
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
                Tables\Filters\SelectFilter::make('Browser profile')
                    ->searchable()
                    ->preload()
                    ->relationship('browser_profile', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Post')
                        ->color("gray")
                        ->requiresConfirmation()
                        ->icon("heroicon-o-arrow-path")
                        ->action(
                            function ($record, $livewire) {
                                (new CraigslistController)->post($record->id);
                                Notification::make()
                                    ->title('Post is queued')
                                    ->success()
                                    ->send();
                            }
                        )
                        ->hidden(! auth()->user()->can('IT | Craigslist Post | Post')),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
