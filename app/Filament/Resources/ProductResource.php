<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Tienda';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nombre')->required(),
            Forms\Components\Textarea::make('description')->label('Descripción')->rows(3),
            Forms\Components\TextInput::make('price')->label('Precio')->numeric()->prefix('$')->required(),
            Forms\Components\TextInput::make('stock')->label('Stock')->numeric()->default(0),
            Forms\Components\Select::make('category')
                ->label('Categoría')
                ->options([
                    'memberships' => 'Membresías',
                    'merchandising' => 'Merchandising',
                    'cosmetics' => 'Cosméticos',
                    'packages' => 'Paquetes',
                ]),
            Forms\Components\TextInput::make('sku')->label('SKU'),
            Forms\Components\Toggle::make('is_active')->label('Activo')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
            Tables\Columns\TextColumn::make('category')->label('Categoría')->badge(),
            Tables\Columns\TextColumn::make('price')->label('Precio')->money('COP'),
            Tables\Columns\TextColumn::make('stock')->label('Stock')->sortable(),
            Tables\Columns\IconColumn::make('is_active')->label('Activo')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
