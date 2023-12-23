<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Product;
use App\Models\Sale;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $modelLabel = 'Penjualan';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function canCreate(): bool
    {
        return auth()->user()->role == Role::KASIR;
    }

    public static function canEdit(Model $record): bool
    {
        return FALSE;
    }

    public static function canDelete(Model $record): bool
    {
        return FALSE;
    }

    public static function canDeleteAny(): bool
    {
        return FALSE;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('sales')
                    ->columnSpanFull()
                    ->grid(2)
                    ->addActionLabel('Tambah Produk')
                    ->schema([
                        Select::make('product')
                            ->options(Product::where('stock', '>', 0)->pluck('name', 'id'))
                            ->required()->live()->searchable(),
                        TextInput::make('quantity')
                            ->visible(fn(Get $get) => $get('product'))
                            ->maxValue(fn(Get $get) => Product::find($get('product'))?->stock)
                            ->required()->integer()->live()->minValue(1)->default(1),
                        Placeholder::make('p_total')->hiddenLabel()
                            ->visible(fn(Get $get) => $get('product') && $get('quantity'))
                            ->content(function (Get $get, Set $set) {
                                $product = Product::find($get('product'));
                                $set('total', $product->sell_price * $get('quantity'));
                                return "Total: Rp. " . ($product->sell_price * $get('quantity'));
                            }),
                        Hidden::make('total')
                            ->default(0)->required()
                    ]),

                Placeholder::make('total_shop')
                    ->hiddenLabel()->columnSpanFull()
                    ->visible(fn(Get $get) => $get('sales'))
                    ->content(function(Get $get) {
                        $totals = 0;

                        foreach($get('sales') as $sale) {
                            $totals += $sale['total'];
                        }

                        return new HtmlString("<h1 class='text-2xl font-bold'>Total Belanjaan: Rp. {$totals}</h1>");
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('created_at')
            ->groups([
                Group::make('created_at')
                    ->label('Waktu Transaksi')
                    ->collapsible(true)
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name Produck')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sell_price')
                    ->label('Harga Jual')->prefix('Rp. ')
                    ->numeric()->sortable(),
                Tables\Columns\TextColumn::make('capital_price')
                    ->label('Harga Modal')->prefix('Rp. ')
                    ->numeric()->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()->sortable(),
                Tables\Columns\TextColumn::make('keuntungan')
                    ->numeric()
                    ->prefix('Rp. ')
                    ->getStateUsing(fn(Sale $record) => ($record->sell_price - $record->capital_price) * $record->quantity),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Transaksi')
                    ->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
