<?php

use yii\helpers\Html;

$this->title = 'Статистика магазина';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="charts-grid text-center">
    <div class="chart-card">
        <h5>Онлайн и офлайн оплата за последние 7 дней</h5>
        <?php
        echo $this->render('line', [
            'labels' => $labels,
            'online' => $online,
            'cash' => $cash,
        ]);
        ?>
    </div>

    <div class="chart-card">
        <h5>Доставленные и отмененные заказы за последние 7 дней</h5>
        <?php
        echo $this->render('bar', [
            'labels' => $labels,
            'online' => $online,
            'cash' => $cash,
        ]);
        ?>
    </div>

    <div class="chart-card">
        <h5>Топ 5 товаров за последние 7 дней</h5>
    </div>

    <div class="chart-card">
        <h5>Распределение заказов по времени</h5>
    </div>
</div>