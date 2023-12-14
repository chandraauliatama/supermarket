<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return auth()->user()->role == Role::ADMIN;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role == Role::ADMIN;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role == Role::ADMIN;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->role == Role::ADMIN;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('stock')
                    ->label('Stok')
                    ->required()->integer()->default(0),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar Produk')
                    ->image()->columnSpanFull(),
                Forms\Components\TextInput::make('sell_price')
                    ->label('Harga Jual')
                    ->reactive()->required()->integer()
                    ->minValue(fn(Get $get) => (int) $get('capital_price')),
                Forms\Components\TextInput::make('capital_price')
                    ->label('Harga Modal')
                    ->reactive()->required()->integer()->default(0),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->columnSpanFull()
                        ->alignCenter()
                        ->width('full')
                        ->height(200),
                    Tables\Columns\TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->size('md')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('sell_price')
                        ->prefix('Harga Jual: Rp. ')->color('success')
                        ->numeric()->sortable(),
                    Tables\Columns\TextColumn::make('capital_price')
                        ->prefix('Harga Modal: Rp. ')->color('danger')
                        ->numeric()->sortable(),
                    Tables\Columns\TextColumn::make('stock')
                        ->prefix('Stok: ')
                        ->numeric()->sortable(),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->prefix('Terakhir Diubah: ')
                        ->dateTime()->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])->space(1.5),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
