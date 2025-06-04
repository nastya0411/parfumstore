<?php

use dosamigos\chartjs\ChartJs;

echo ChartJs::widget([
    'type' => 'radar',
    'options' => [
        'height' => 400,
        'width' => 600,
    ],
    'data' => [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => "Доставка",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,215,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => $deliveryData,
            ],
            [
                'label' => "Самовывоз",
                'backgroundColor' => "rgba(255, 116, 9, 0.53)",
                'borderColor' => "rgb(255, 110, 20)",
                'pointBackgroundColor' => "rgb(183, 111, 56)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgb(233, 124, 46)",
                'data' => $pickupData,
            ]
        ]
    ],
    'clientOptions' => [
        'plugins' => ['legend' => ['display' => true]],
        'scales' => [
            'r' => [
                'beginAtZero' => true,
                'ticks' => [
                    'stepSize' => 1,
                    'callback' => "function(value) { return Number.isInteger(value) ? value : null; }"
                ]
            ]
        ]
    ]
]);
