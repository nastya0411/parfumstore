<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->registerCssFile('@web/css/statistics.css', ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="chart-container">
    <?= ChartJs::widget([
        'type' => 'pie',
        'options' => [
            'height' => 600,
            'width' => 900,
        ],
        'data' => [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "Заказы с оплатой онлайн",
                    'backgroundColor' => "rgba(255, 116, 9, 0.53)",
                    'borderColor' => "rgb(255, 110, 20)",
                    'pointBackgroundColor' => "rgb(183, 111, 56)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgb(233, 124, 46)",
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