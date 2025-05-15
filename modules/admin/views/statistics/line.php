<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->registerCssFile('@web/css/statistics.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="chart-container">
    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 600,
            'width' => 900,
        ],
        'data' => [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "Заказы с оплатой онлайн",
                    'backgroundColor' => "rgba(179,181,198,0.2)",
                    'borderColor' => "rgba(179,181,198,1)",
                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                    'data' => array_map('intval', $online),
                ],
                [
                    'label' => "Заказы с оплатой при получении",
                    'backgroundColor' => "rgba(255,99,132,0.2)",
                    'borderColor' => "rgba(255,99,132,1)",
                    'pointBackgroundColor' => "rgba(255,99,132,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(255,99,132,1)",
                    'data' => array_map('intval', $cash),
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