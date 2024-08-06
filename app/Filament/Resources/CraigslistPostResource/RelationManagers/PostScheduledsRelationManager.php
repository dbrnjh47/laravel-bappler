<?php

namespace App\Filament\Resources\CraigslistPostResource\RelationManagers;

use App\Http\Services\PostScheduled\PostScheduledServices;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class PostScheduledsRelationManager extends RelationManager
{
    protected static string $relationship = 'post_scheduleds';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\DatePicker::make('start_at')->beforeOrEqual('end_at')->required(),
                \Filament\Forms\Components\DatePicker::make('end_at')->required(),
                \Filament\Forms\Components\TimePicker::make('time_at')->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('start_at')
                    ->label("Data"),
                Tables\Columns\TextColumn::make('time_at')
                    ->time("time")->dateTime('H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Update')
                        ->form([
                            \Filament\Forms\Components\DatePicker::make('start_at')

                                ->required(),
                            // \Filament\Forms\Components\DatePicker::make('end_at')->required(),
                            \Filament\Forms\Components\TimePicker::make('time_at')->required(),
                        ])
                        ->action(
                            function ($record, $livewire, $data) {

                                (new PostScheduledServices)->update($record, $data);
                                Notification::make()
                                    ->title('Post is queued')
                                    ->success()
                                    ->send();
                            }
                        )
                        ->hidden(function ($record, $livewire) {
                            return !Gate::allows('update', $record);
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
