<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CraigslistPostTemplateResource\Pages;
use App\Filament\Resources\CraigslistPostTemplateResource\RelationManagers;
use App\Http\Services\SaveFileServices;
use App\Models\CraigslistPostTemplate;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CraigslistPostTemplateResource extends Resource
{
    protected static ?string $model = CraigslistPostTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 53;

    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Post')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\FileUpload::make('preview')
                                ->required()
                                ->disk('public_user')
                                ->previewable(true)
                                ->afterStateUpdated(function ($state, $record) {
                                    $imgName = (new SaveFileServices)->saveOne($state, CraigslistPostTemplate::PATH, false);


                                    // Сохраняем имя файла в базе данных
                                    $record->preview = $imgName;
                                    $record->save();
                                }),

                            Forms\Components\RichEditor::make('description')->required(),

                            Forms\Components\Section::make()
                                ->columns([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->schema([
                                    Forms\Components\DatePicker::make('posting_start_at')->required(),
                                    Forms\Components\DatePicker::make('posting_end_at')->required(),
                                ]),

                            Forms\Components\Section::make()
                                ->columns([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->schema([
                                    Forms\Components\Select::make('bank_card_id')
                                            ->relationship(name: 'bank_card', titleAttribute: 'card_number')
                                            ->native(0)
                                            ->searchable(['bank', 'first_name', 'last_name', 'card_number'])
                                            ->preload()
                                            ->required(),
                                    Forms\Components\Select::make('browser_profile_id')
                                            ->relationship(name: 'browser_profile', titleAttribute: 'name')
                                            ->native(0)
                                            ->searchable(['name', 'uuid'])
                                            ->preload()
                                            ->required(),
                                ]),

                            Forms\Components\Select::make('status')
                                        ->options([
                                            'scheduled' => 'Scheduled',
                                            'not_active' => 'Not active',
                                        ])
                                        ->columnSpanFull()
                                        ->native(0)
                                        ->required(),
                        ]),

                    Forms\Components\Wizard\Step::make('Info')
                        ->schema([
                            Forms\Components\Section::make()
                                ->columns([
                                    'sm' => 1,
                                    'lg' => 2,
                                ])
                                ->schema([
                                    Forms\Components\TextInput::make('city')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('zip')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Select::make('email_privacy')
                                        ->options([
                                            'cl_mail_relay' => 'CL mail relay',
                                            'show' => 'Show',
                                            'no_replies' => 'No replies',
                                        ])
                                        ->columnSpanFull()
                                        ->native(0)
                                        ->required(),

                                    Forms\Components\Toggle::make('show_phone')->onColor('success')
                                        ->offColor('danger'),
                                    Forms\Components\Toggle::make('phone_calld')->onColor('success')
                                        ->offColor('danger'),
                                    Forms\Components\Toggle::make('text_ok')->onColor('success')
                                        ->offColor('danger')->columnSpanFull(),

                                    Forms\Components\TextInput::make('phone_number')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('name')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('extension')
                                        ->maxLength(255),
                                ])
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([])
            ->columns([
                Tables\Columns\ViewColumn::make('title')
                    ->view('tables.columns.craig-list.title-and-preview')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('city')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bank_card.card_number')
                    ->description(fn ($record): string => ($record->bank_card ? "{$record->bank_card->first_name} {$record->bank_card->last_name}" : ''))
                    ->label('Card')
                    ->url(fn ($record): string => ($record->bank_card_id ? BankCardResource::getUrl('view', ['record' => $record->bank_card_id]) : ''))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('browser_profile.name')
                    ->description(fn($record): string => ($record->browser_profile ? $record->browser_profile->uuid : ''))
                    ->label('Browser profile')
                    ->url(fn($record): string => ($record->browser_profile_id ? BrowserProfileResource::getUrl('view', ['record' => $record->browser_profile_id]) : ''))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->searchable(),

                Tables\Columns\TextColumn::make('posting_start_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('posting_end_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCraigslistPostTemplates::route('/'),
            'create' => Pages\CreateCraigslistPostTemplate::route('/create'),
            'view' => Pages\ViewCraigslistPostTemplate::route('/{record}'),
            'edit' => Pages\EditCraigslistPostTemplate::route('/{record}/edit'),
        ];
    }
}
