<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use Exception;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'posts';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('sub_category_id', null))
                    ->searchable()
                    ->required(),

                Select::make('sub_category_id')
                    ->label('Sub Category')
                    ->options(fn (Get $get): Collection => SubCategory::query()->where('category_id', $get('category_id'))
                    ->pluck('name', 'id'))
                    ->preload()
                    ->live()
                    ->searchable(),

                TextInput::make('title')
                    ->columnSpan('full')
                    ->required(),

                RichEditor::make('content')
                    ->fileAttachmentsDisk('s3')
                    ->fileAttachmentsDirectory('attachments')
                    ->columnSpan('full')
                    ->required(),

                TagsInput::make('tags')
                    ->separator()
                    ->columnSpan('full'),

                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->disk('s3')
                    ->visibility('public')
                    ->collection('thumbnail')
                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                    ->maxSize(500)
                    ->columnSpan('full')
                    ->openable(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Post $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Post $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name'),

                TextColumn::make('subCategory.name'),

                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->collection('thumbnail'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('category')
                    ->form([
                        Select::make('category_id')
                            ->options(Category::pluck('name', 'id'))
                            ->label('Category')
                            ->preload()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('sub_category_id', null)),

                        Select::make('sub_category_id')
                            ->label('Sub Category')
                            ->options(fn (Get $get): Collection => SubCategory::query()->where('category_id', $get('category_id'))
                                ->pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->live(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['category_id'], fn (Builder $query, $data): Builder => $query->where('category_id', $data))
                            ->when($data['sub_category_id'], fn (Builder $query, $data): Builder => $query->where('sub_category_id', $data));
                    })
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make('show')
                    ->label('Show')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn(Post $record): string => static::getUrl('view', ['record' => $record]))
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderByDesc('created_at'); // TODO: Change the autogenerated stub
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record:slug}/edit'),
            'view' => Pages\ViewPost::route('/{record:slug}/show')
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content'];
    }
}
