<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $transactionTime = now();

        foreach ($data['sales'] as $sale) {
            $product = Product::find($sale['product']);

            $successSale = static::getModel()::create([
                'name' => $product->name,
                'sell_price' => $product->sell_price,
                'capital_price' => $product->capital_price,
                'quantity' => $sale['quantity'],
                'created_at' => $transactionTime,
                'updated_at' => $transactionTime,
            ]);
            
            $product->stock = $product->stock - $sale['quantity'];
            $product->save();
        }

        return $successSale;
    }
}
