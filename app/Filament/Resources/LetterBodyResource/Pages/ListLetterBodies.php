<?php

namespace App\Filament\Resources\LetterBodyResource\Pages;

use App\Filament\Resources\LetterBodyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLetterBodies extends ListRecords
{
    protected static string $resource = LetterBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
