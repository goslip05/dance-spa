<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessionalResource\Pages;
use App\Models\Professional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfessionalResource extends Resource
{
    protected static ?string $model = Professional::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Gestión de Usuarios';
    protected static ?string $modelLabel = 'Profesional';
    protected static ?string $pluralModelLabel = 'Profesionales';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->relationship('user', 'name')
                ->required()
                ->searchable(),
            Forms\Components\Textarea::make('bio')
                ->label('Biografía')
                ->rows(3),
            Forms\Components\TextInput::make('phone')
                ->label('Teléfono')
                ->tel(),
            Forms\Components\TagsInput::make('specialties')
                ->label('Especialidades')
                ->placeholder('Agregar especialidad'),
            Forms\Components\Select::make('serviceCategories')
                ->label('Categorías de Servicio')
                ->multiple()
                ->relationship('serviceCategories', 'name')
                ->preload(),
            Forms\Components\Toggle::make('is_available')
                ->label('Disponible')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Nombre')->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
            Tables\Columns\TextColumn::make('serviceCategories.name')->label('Categorías')->badge(),
            Tables\Columns\IconColumn::make('is_available')->label('Disponible')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfessionals::route('/'),
            'create' => Pages\CreateProfessional::route('/create'),
            'edit' => Pages\EditProfessional::route('/{record}/edit'),
        ];
    }
}
