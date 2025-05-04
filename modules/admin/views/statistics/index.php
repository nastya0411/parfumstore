<?php

use yii\helpers\Html;

$this->title = 'Статистика магазина';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/statistics.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/statistics.js', [
    'depends' => [\yii\web\JqueryAsset::class]
]);
?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="charts-grid">
    <div class="chart-card">
        <h5>Заказы за последние 7 дней</h5>
        <canvas id="ordersChart"></canvas>
    </div>

    <div class="chart-card">
        <h5>Доход по дням</h5>
        <canvas id="revenueChart"></canvas>
    </div>

    <div class="chart-card">
        <h5>Топ 5 товаров за последние 7 дней</h5>
        <canvas id="topProductsChart"></canvas>
    </div>

    <div class="chart-card">
        <h5>Распределение заказов по времени</h5>
        <canvas id="timeDistributionChart"></canvas>
    </div>
</div>