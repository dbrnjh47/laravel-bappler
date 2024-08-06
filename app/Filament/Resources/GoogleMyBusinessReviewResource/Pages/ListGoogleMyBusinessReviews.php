<?php

namespace App\Filament\Resources\GoogleMyBusinessReviewResource\Pages;

use App\Filament\Resources\GoogleMyBusinessReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGoogleMyBusinessReviews extends ListRecords
{
    protected static string $resource = GoogleMyBusinessReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
