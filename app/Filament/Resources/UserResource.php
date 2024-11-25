<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->collection('avatar')
                    ->maxSize(500)
                    ->columnSpanFull()
                    ->avatar(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->required(),

                Select::make('roles')
                    ->label('Roles')
                    ->options(Role::pluck('name', 'id')->toArray()) // Menampilkan daftar role
                    ->multiple() // Mengizinkan multiple selection
                    ->preload() // Untuk memuat data dengan cepat
                    ->relationship('roles', 'name') // Relasi dengan role
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->nullable()
                    ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null) // Hash password jika ada
                    ->dehydrated(fn ($state) => filled($state)) // Tidak menyertakan field jika kosong
                    ->required(fn ($context) => $context === 'create'), // Wajib diisi hanya pada create

                Fieldset::make('address')
                    ->label('Address')
                    ->relationship('address')
                    ->schema([
                        TextInput::make('province'),
                        TextInput::make('city'),
                        TextInput::make('district'),
                        TextInput::make('sub_district'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatar')
                    ->circular(),

                TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label('Email Verified Date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (User $record) => $record->id !== auth()->id()),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record:username}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
