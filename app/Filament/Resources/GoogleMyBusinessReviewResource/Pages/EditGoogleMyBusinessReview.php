<?php

namespace App\Filament\Resources\GoogleMyBusinessReviewResource\Pages;

use App\Filament\Resources\GoogleMyBusinessReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGoogleMyBusinessReview extends EditRecord
{
    protected static string $resource = GoogleMyBusinessReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
