<?php

namespace App\Filament\Resources\LetterBodyResource\Pages;

use App\Filament\Resources\LetterBodyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLetterBody extends EditRecord
{
    protected static string $resource = LetterBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
