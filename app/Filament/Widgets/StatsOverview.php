<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Akun Terdaftar', User::count()),
            Stat::make('Jumlah Jenis Produk', Product::count()),
            Stat::make('Jumlah Kuantitas Produk', Product::sum('stock')),
            Stat::make('Jumlah Transaksi', Sale::distinct('created_at')->count())
                ->chart([2,3,2,5,2,7,8,5,9])
                ->color('success'),
            Stat::make('Total Barang Terjual', Sale::sum('quantity'))
                ->chart([2,3,2,5,2,7,8,5,9])
                ->color('danger'),
            Stat::make('Total Keuntungan', function() {
                    $sales = Sale::all();

                    return "Rp. " . $sales->sum(function ($sale) {
                        return ($sale->sell_price - $sale->capital_price) * $sale->quantity;
                    });
                })
                ->chart([2,3,5,2,7,8,5,9,19])
                ->color('success'),
        ];
    }
}
