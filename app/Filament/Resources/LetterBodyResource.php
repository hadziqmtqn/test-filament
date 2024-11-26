<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\LetterBodyResource\Pages;
use App\Models\LetterBody;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LetterBodyResource extends Resource
{
    protected static ?string $model = LetterBody::class;

    protected static ?string $slug = 'letter-bodies';

    protected static ?string $navigationGroup = 'Letter Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpanFull()
                    ->required(),

                TinyEditor::make('description')
                    ->fileAttachmentsDisk('s3')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->columnSpanFull()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make('show')
                    ->label('Show')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn(LetterBody $record): string => static::getUrl('view', ['record' => $record]))
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLetterBodies::route('/'),
            'create' => Pages\CreateLetterBody::route('/create'),
            'edit' => Pages\EditLetterBody::route('/{record:slug}/edit'),
            'view' => Pages\ViewLetterBody::route('{record:slug}/show')
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}
