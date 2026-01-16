<?php

namespace App\Filament\Admin\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class UserRadialbar extends ApexChartWidget
{

      protected static ?int $sort = 1;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'userRadialbar';
  //  protected static bool $isCollapsible = true;

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
                'type' => 'radialBar',
                'height' => 300,
            ],
            'series' => [75],
            'plotOptions' => [
                'radialBar' => [
                    'hollow' => [
                        'size' => '70%',
                    ],
                    'dataLabels' => [
                        'show' => true,
                        'name' => [
                            'show' => true,
                            'fontFamily' => 'inherit'
                        ],
                        'value' => [
                            'show' => true,
                            'fontFamily' => 'inherit',
                            'fontWeight' => 600,
                            'fontSize' => '20px'
                        ],
                    ],

                ],
            ],
            'stroke' => [
                'lineCap' => 'round',
            ],
            'labels' => ['System'],
            'colors' => ['#00b746'],
        ];
    }
}
