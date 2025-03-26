<?php
 
 use yii\bootstrap5\Html;
 use yii\helpers\VarDumper;
 
 // VarDumper::dump($model->attributes, 10, true);
 ?>
 
 <div class="card mb-4">
   <div class="card-header fw-semibold fs-5">
     № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
   </div>
   <div class="card-body">
     <h5 class="card-title text-decoration-underline">Дата и время услуги: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time ?></h5>
     <p class="card-text">Клиент: <span class="fs-5"><?= $model->user->full_name ?></span></p>
 
     
     <p class="card-text">Состав заказа: <span class="fs-5"><?= $model->service->title ?></span></p>
     <p class="card-text fs-5"><span class="text-black-50">Состав заказа: </span><?= $model->service->title ?></p>
 
 
     <p class="card-text fs-5"><span class="text-black-50">Статус: </span><?= $model->status->title ?></p>
     
     <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => "btn btn-outline-primary"]) ?>
   </div>
 </div>