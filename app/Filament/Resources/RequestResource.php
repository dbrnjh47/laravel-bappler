<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Request;
use Carbon\Carbon;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?int $navigationSort = 41;

    protected static ?string $modelLabel = 'Visit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('domain_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->maxLength(46),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('region')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hostname')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ISP')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ASN')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('organization')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('timezone')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric()
                    ->default(0.00000000),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric()
                    ->default(0.00000000),
                Forms\Components\TextInput::make('fraud_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('keyword')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('search_term')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('$'),
                Forms\Components\TextInput::make('UTM')
                    ->required(),
                Forms\Components\Toggle::make('is_fill_ipqualityscore')
                    ->required(),
                Forms\Components\Toggle::make('is_fill_adsgoogle')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('domain.namecheap_domain_name')
                    ->label('Domain')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('region')
                    ->label('Region')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('hostname')
                    ->label('Hostname')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ISP')
                    ->label('ISP')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ASN')
                    ->label('ASN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('organization')
                    ->label('Organization')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('timezone')
                    ->label('Timezone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Longitude')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fraud_score')
                    ->label('Fraud Score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keyword')
                    ->label('Keyword')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('search_term')
                    ->label('Search Term')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Cost')
                    ->money()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('UTM.utm_source')
                    ->label('UTM Source')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('UTM.utm_medium')
                    ->label('UTM Medium')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('UTM.utm_campaign')
                    ->label('UTM Campaign')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('UTM.utm_term')
                    ->label('UTM Term')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('UTM.utm_content')
                    ->label('UTM Content')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\IconColumn::make('is_fill_ipqualityscore')
                    ->hidden()
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_fill_adsgoogle')
                    ->hidden()
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->hidden()
                    ->dateTime()
                    ->sortable(),
            ])->defaultSort('created_at')
            ->filters([
                Tables\Filters\SelectFilter::make('Domain')
                    ->relationship('domain', 'namecheap_domain_name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Domain')
                    ->indicator('Domain'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->default(now()->subDays(now()->dayOfWeek - 1)),
                        DatePicker::make('created_until')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }

                        return $indicators;
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Section::make('Request Info')
                ->schema([
                    TextEntry::make('domain.namecheap_domain_name')->label('Domain Name'),
                    TextEntry::make('ip_address')->label('IP Address'),
                    TextEntry::make('created_at')->label('Date')->dateTime(),
                ])->columns(3),

                Section::make('UTM')
                ->schema([
                    TextEntry::make('UTM.utm_source')->label('Source'),
                    TextEntry::make('UTM.utm_medium')->label('Medium'),
                    TextEntry::make('UTM.utm_campaign')->label('Campaign'),
                    TextEntry::make('UTM.utm_term')->label('Term'),
                    TextEntry::make('UTM.utm_content')->label('Content'),
                ])->columns(2),

                Section::make('IP Quality Score Info')
                ->schema([
                    TextEntry::make('country')->label('Country'),
                    TextEntry::make('region')->label('Region'),
                    TextEntry::make('city')->label('City'),
                    TextEntry::make('hostname')->label('Hostname'),
                    TextEntry::make('ISP')->label('ISP'),
                    TextEntry::make('ASN')->label('ASN'),
                    TextEntry::make('organization')->label('Organization'),
                    TextEntry::make('timezone')->label('Timezone'),
                    TextEntry::make('latitude')->label('Latitude'),
                    TextEntry::make('longitude')->label('Longitude'),
                    TextEntry::make('fraud_score')->label('Fraud Score'),
                ])->columns(3)
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
            'index' => Pages\ListRequests::route('/'),
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }
}
