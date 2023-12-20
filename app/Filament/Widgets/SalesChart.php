<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Jenis Barang Terjual Dalam Seminggu';

    protected static string $color = 'success';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
        'scales' => [
            'y' => [
                'ticks' => [
                    'stepSize' => 1, // Menampilkan angka bulat saja dengan langkah 1
                ],
            ],
        ],
    ];

    protected function getData(): array
    {
        $data = Trend::model(Sale::class)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jenis Barang',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->translatedFormat('l, j M Y')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
