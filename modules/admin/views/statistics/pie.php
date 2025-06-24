<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->registerCssFile('@web/css/statistics.css', ['depends' => [\yii\web\YiiAsset::class]]);
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

// Подготавливаем цвета для каждого сектора
$sectorBackgroundColors = [];
$sectorBorderColors = [];
foreach ($data as $index => $value) {
    $sectorBackgroundColors[] = $backgroundColors[$index % count($backgroundColors)];
    $sectorBorderColors[] = $borderColors[$index % count($borderColors)];
}
?>

<div class="chart-container">
    <?= ChartJs::widget([
        'type' => 'pie',
        'options' => [
            'height' => 700,
            'width' => 900,
        ],
        'data' => [
            'labels' => $labels,
            'datasets' => [ 
                [
                    'label' => "Заказы с оплатой онлайн",
                    'backgroundColor' => $sectorBackgroundColors,
                    'borderColor' => $sectorBorderColors,
                    'pointBackgroundColor' => "rgb(183, 111, 56)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgb(252, 105, 0)",
                    'data' => array_map('intval', $data),
                ]
            ]
        ],
        'clientOptions' => [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'callback' => "function(value) { return Number.isInteger(value) ? value : null; }"
                    ]
                ]
            ]
        ]
    ]) ?>
</div>