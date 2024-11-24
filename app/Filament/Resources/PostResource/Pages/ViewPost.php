<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(), // Tambahkan aksi edit jika diperlukan
        ];
    }
}
