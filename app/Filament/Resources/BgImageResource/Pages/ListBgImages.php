<?php

namespace App\Filament\Resources\BgImageResource\Pages;

use App\Filament\Resources\BgImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBgImages extends ListRecords
{
    protected static string $resource = BgImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
