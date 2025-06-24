<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->registerCssFile('@web/css/statistics.css', ['depends' => [\yii\web\YiiAsset::class]]);

// Более интересная палитра серо-оранжевых оттенков
$backgroundColors = [
    'rgba(255, 165, 75, 0.8)',
    'rgba(250, 145, 60, 0.8)',
    'rgba(240, 130, 50, 0.8)',
    'rgba(225, 115, 40, 0.8)',
    'rgba(210, 100, 30, 0.8)',
    'rgba(195, 85, 25, 0.8)',
    'rgba(180, 75, 20, 0.8)',
    'rgba(160, 65, 15, 0.8)',
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

<div class="chart-container">
    <?= ChartJs::widget([
        'type' => 'pie',
        'options' => [
            'height' => 300,
            'width' => '100%',
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => '#444',
                        'font' => ['size' => 13],
                        'padding' => 15,
                    ],
                    'position' => 'right',
                    'align' => 'center',
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(30, 30, 30, 0.9)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderWidth' => 1,
                    'borderColor' => 'rgba(255, 255, 255, 0.3)',
                    'padding' => 10,
                    'boxPadding' => 5,
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Распределение заказов по категориям',
                    'color' => '#333',
                    'font' => ['size' => 16],
                    'padding' => 20
                ]
            ],
            'hover' => [
                'mode' => 'nearest',
                'intersect' => true
            ],
        ],
        'data' => [
            'labels' => $labels,
            'datasets' => [ 
                [
                    'label' => "Заказы с оплатой онлайн",
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 2,
                    'hoverBorderColor' => "#ffffff",
                    'hoverBorderWidth' => 3,
                    'data' => array_map('intval', $data),
                ]
            ]
        ],
        'clientOptions' => [
            'maintainAspectRatio' => false,
            'animation' => [
                'animateRotate' => true,
                'animateScale' => true,
                'duration' => 1000,
                'easing' => 'easeOutQuart'
            ],
            'plugins' => [
                'tooltip' => [
                    'enabled' => true
                ],
                'legend' => [
                    'display' => true
                ]
            ]
        ]
    ]) ?>
</div>