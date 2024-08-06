<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CraigslistPostResource\Pages;
use App\Filament\Resources\CraigListPostResource\RelationManagers;
use App\Filament\Resources\CraigslistPostResource\RelationManagers\PostScheduledsRelationManager;
use App\Http\Controllers\Craigslist\CraigslistController;
use App\Models\CraigslistPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
class CraigslistPostResource extends Resource
{
    protected static ?string $model = CraigslistPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Craigslist Posts';
    protected static ?string $modelLabel = 'Craigslist Posts';

    protected static ?int $navigationSort = 52;

    protected static ?string $navigationGroup = 'Marketing';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('uuid')
    //                 ->label('UUID')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('title')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('preview')
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('city')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('zip')
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('description')
    //                 ->required()
    //                 ->maxLength(3550),
    //             Forms\Components\TextInput::make('email_privacy')
    //                 ->email()
    //                 ->required(),
    //             Forms\Components\Toggle::make('show_phone')
    //                 ->required(),
    //             Forms\Components\Toggle::make('phone_calld')
    //                 ->required(),
    //             Forms\Components\Toggle::make('text_ok')
    //                 ->required(),
    //             Forms\Components\TextInput::make('phone_number')
    //                 ->tel()
    //                 ->required()
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('name')
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('extension')
    //                 ->maxLength(255),
    //             Forms\Components\TextInput::make('browser_profile_id')
    //                 ->required()
    //                 ->numeric(),
    //             Forms\Components\DateTimePicker::make('last_posted_at'),
    //         ]);
    // }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Info')
                    // ->description('')
                    ->schema([
                        \Filament\Infolists\Components\ViewEntry::make('title')->view('tables.columns.craig-list.title-and-preview')->columnSpanFull(),
                        \Filament\Infolists\Components\TextEntry::make('uuid')->label('UUID'),

                        \Filament\Infolists\Components\TextEntry::make('browser_profile.name')
                            ->url(fn($record): string => ($record->browser_profile ? BrowserProfileResource::getUrl('view', ['record' => $record->browser_profile]) : ''))
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

    public static function table(Table $table): Table
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

                Tables\Columns\TextColumn::make('browser_profile.name')
                    ->description(fn($record): string => ($record->browser_profile ? $record->browser_profile->uuid : ''))
                    ->label('Browser profile')
                    ->url(fn($record): string => ($record->browser_profile_id ? BrowserProfileResource::getUrl('view', ['record' => $record->browser_profile_id]) : ''))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

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

    public static function getRelations(): array
    {
        return [
            PostScheduledsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCraigslistPosts::route('/'),
            // 'create' => Pages\CreateCraigslistPost::route('/create'),
            'view' => Pages\ViewCraigslistPost::route('/{record}'),
            // 'edit' => Pages\EditCraigslistPost::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
