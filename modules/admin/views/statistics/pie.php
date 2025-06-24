<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->registerCssFile('@web/css/statistics.css', ['depends' => [\yii\web\YiiAsset::class]]);

// Серо-оранжевые оттенки для разных секторов
$backgroundColors = [
    'rgba(250, 160, 80, 0.8)',
    'rgba(245, 140, 70, 0.8)',
    'rgba(235, 125, 60, 0.8)',
    'rgba(220, 110, 50, 0.8)',
    'rgba(200, 95, 40, 0.8)',
    'rgba(180, 85, 35, 0.8)',
    'rgba(160, 75, 30, 0.8)',
    'rgba(140, 65, 25, 0.8)',
];

$borderColors = [
    '#ff9933',
    '#ff8811',
    '#e67300',
    '#cc6600',
    '#b35900',
    '#994d00',
    '#804000',
    '#663300'
];
?>

<div class="chart-container-pie">
    <?= ChartJs::widget([
        'type' => 'pie',
        'options' => [
            'height' => 420,
            'width' => 900,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => '#333',
                        'font' => [
                            'size' => 14
                        ]
                    ]
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(50, 50, 50, 0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff'
                ]
            ]
        ],
        'data' => [
            'labels' => $labels,
'datasets' => [ 
    [
        'label' => "Заказы с оплатой онлайн",
        'backgroundColor' => array_slice($backgroundColors, 0, count($data)),
        'borderColor' => array_slice($borderColors, 0, count($data)),
        'borderWidth' => 2,
        'hoverBorderColor' => "#ffffff",
        'data' => array_map('intval', $data),
    ]
]
        ],
        'clientOptions' => [
            'maintainAspectRatio' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => 'Распределение заказов по категориям',
                    'font' => ['size' => 18],
                    'color' => '#444'
                ]
            ]
        ]
    ]) ?>
</div>