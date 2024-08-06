<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DomainResource\Pages;
use App\Filament\Resources\DomainResource\RelationManagers;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'IT';

    protected static ?int $navigationSort = 21;

    public static function getNavigationBadge(): ?string
    {
        $alreadyExpiredCount = static::getModel()::where('namecheap_is_expired', true)->count();
        $soonExpiredCount = static::getModel()::whereDate('namecheap_expires', '<=', Carbon::now()->addDays(90))->count();

        $result = null;
        if ($alreadyExpiredCount > 0 || $soonExpiredCount > 0)
            $result = $alreadyExpiredCount . ' / ' . $soonExpiredCount;

        return $result;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('namecheap_account')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('namecheap_domain_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('namecheap_domain_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('namecheap_created')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('namecheap_expires')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('namecheap_is_expired')
                    ->required(),
                Forms\Components\Toggle::make('namecheap_is_locked')
                    ->required(),
                Forms\Components\Toggle::make('namecheap_is_autorenew')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('namecheap_account')
                    ->label('Account Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('namecheap_domain_id')
                    ->numeric()
                    ->hidden(),
                Tables\Columns\TextColumn::make('namecheap_domain_name')
                    ->label('Domain Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('namecheap_created')
                    ->label('Domain Created')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('namecheap_expires')
                    ->label('Domain Expires')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('namecheap_is_expired')
                    ->label('Is Expired')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('namecheap_is_locked')
                    ->label('Is Locked')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('namecheap_is_autorenew')
                    ->label('Is AutoRenew')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->hidden(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->hidden(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                /*
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                */
            ])
            ->recordClasses(fn (Model $record) => match (true) {
                Carbon::parse($record->namecheap_expires)->diffInDays(Carbon::now()) <= 0 => 'bg-red-200', // Если срок истек
                Carbon::parse($record->namecheap_expires)->diffInDays(Carbon::now()) > 0 && Carbon::parse($record->namecheap_expires)->diffInDays(Carbon::now()) <= 90 => 'bg-orange-200', // Если до истечения <= 90 дней
                default => null,
            });
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
            'index' => Pages\ListDomains::route('/'),
            //'create' => Pages\CreateDomain::route('/create'),
            //'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
