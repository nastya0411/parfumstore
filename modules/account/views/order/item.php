<?php

use yii\bootstrap5\Html;

?>

<div class="card mb-4">
  <div class="card-header fw-semibold fs-5">
    № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
  </div>
  <div class="card-body">
    <h5 class="card-title text-decoration-underline">Дата и время услуги: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time ?></h5>
    <p class="card-text">Состав заказа: 
        <span class="fs-5">
          <?= $model->service_id 
              ? $model->service->title 
              : $model->other
          ?>    
        </span>
    </p>
    <p class="card-text fs-5"><span class="text-black-50">Статус: </span><?= $model->status->title ?></p>
    
    <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => "btn btn-outline-primary"]) ?>
  </div>
</div>