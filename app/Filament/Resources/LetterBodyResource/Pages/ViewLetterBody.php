<?php

namespace App\Filament\Resources\LetterBodyResource\Pages;

use App\Filament\Resources\LetterBodyResource;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLetterBody extends ViewRecord
{
    protected static string $resource = LetterBodyResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->color('warning'), // Tambahkan aksi edit jika diperlukan
        ];
    }
}
