<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Статистика магазина';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<div>
    <?= Html::a('За текущую неделю', ['index', 'period' => 'week'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('За предыдущую неделю', ['index', 'period' => 'next_week'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('За 2 недели', ['index', 'period' => '2weeks'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('За квартал', ['index', 'period' => 'quarter'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('За текущий месяц', ['index', 'period' => 'month'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('За предыдущий месяц', ['index', 'period' => 'next_month'], ['class' => 'btn btn-orange-style']) ?>
</div>
<div class="charts-grid text-center">
    <div class="chart-card">
        <div style="height: 48px;">
            <h5>Онлайн и офлайн оплата за <?= $title ?></h5>
        </div>
        <?php
        echo $this->render('line', [
            'labels' => $labels,
            'online' => $online,
            'cash' => $cash,
        ]);
        ?>
    </div>

    <div class="chart-card">
        <div style="height: 48px;">
            <h5>Доставленные и отмененные заказы за <?= $title ?></h5>
        </div>
        <?php
        echo $this->render('bar', [
            'labels' => $labels,
            'delivered' => $delivered,
            'cancelled' => $cancelled,
        ]);
        ?>
    </div>

    <div class="chart-card">
        <div style="height: 20px;">
            <h5>Топ 5 товаров за <?= $title ?></h5>
        </div>
        <?php
        echo $this->render('pie', [
            'labels' => $topProductsLabels,
            'data' => $topProductsData,
        ]);
        ?>
    </div>

    <div class="chart-card">
        <div style="height: 48px;">
            <h5>Распределение заказов по времени за <?= $title ?></h5>
        </div>
        <?php
        echo $this->render('radar', [
            'labels' => $timeLabels,
            'deliveryData' => $deliveryData,
            'pickupData' => $pickupData,
        ]);
        ?>
    </div>
</div>
<?php Pjax::end(); ?>