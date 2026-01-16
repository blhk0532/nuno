<?php

namespace App\Filament\Admin\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class UserDonut extends ApexChartWidget
{
   // protected static bool $isCollapsible = true;
     protected static ?int $sort = 1;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'userDonut';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = '';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [2, 4, 6, 10, 14],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
