<?php

namespace App\Filament\Resources\LetterBodyResource\Pages;

use App\Filament\Resources\LetterBodyResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditLetterBody extends EditRecord
{
    protected static string $resource = LetterBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View Detail') // Label tombol
                ->icon('heroicon-o-eye') // Ikon tombol
                ->color('primary') // Warna tombol
                ->url(fn() => static::getResource()::getUrl('view', ['record' => $this->record->slug])) // URL menuju halaman ViewRecord
                ->tooltip('View the details of this record'), // Tooltip untuk tombol
        ];
    }
}
