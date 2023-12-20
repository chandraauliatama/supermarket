<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Sale;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Lakukan Transaksi'),
            Actions\Action::make('print')->label('Cetak Laporan Penjualan')
                ->requiresConfirmation()
                ->url(shouldOpenInNewTab: true, url: route('printSalesReport')),
        ];
    }
}
