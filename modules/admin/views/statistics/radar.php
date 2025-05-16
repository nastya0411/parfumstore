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
                'backgroundColor' => "rgba(54, 162, 235, 0.2)",
                'borderColor' => "rgb(54, 162, 235)",
                'pointBackgroundColor' => "rgb(54, 162, 235)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgb(54, 162, 235)",
                'data' => $deliveryData,
            ],
            [
                'label' => "Самовывоз",
                'backgroundColor' => "rgba(255, 99, 132, 0.2)",
                'borderColor' => "rgb(255, 99, 132)",
                'pointBackgroundColor' => "rgb(255, 99, 132)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgb(255, 99, 132)",
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
