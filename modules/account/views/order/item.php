<?php

use yii\bootstrap5\Html;


?>
<?php $this->registerCssFile('@web/css/card-style.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]); ?>


<div class="card mb-4 mt-4 text-black">
  <div class="card-header fw-semibold fs-5 text-bold ">
    № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
  </div>
  <div class="card-body">
    <h5 class="card-title">Дата и время получения заказа: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time ?></h5>
    <h5 class="card-title">Статус заказа: <?= $model->status->title ?></h5>
    <p class="card-text">Количество товаров: <?= $model->amount ?> </p>
    <p class="card-text">Сумма заказа: <?= $model->cost ?> Р </p>
    <div class="d-flex justify-content-end">
      <?= Html::a('Просмотреть заказ',['/shop/order/view', 'id' => $model->id],['class' => 'btn btn-show-style text-white']) ?>
    </div>
  </div>
</div>