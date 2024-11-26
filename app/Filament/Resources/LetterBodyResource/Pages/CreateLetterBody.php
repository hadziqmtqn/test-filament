<?php

namespace App\Filament\Resources\LetterBodyResource\Pages;

use App\Filament\Resources\LetterBodyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLetterBody extends CreateRecord
{
    protected static string $resource = LetterBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
