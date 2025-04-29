<?php
 
 use yii\bootstrap5\Html;
 ?>
 <div class="card my-3">
   <h5 class="card-header">Заказ № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s')?></h5>
   <div class="card-body">
     <h5 class="card-title">Статус заказа: <?= $model->status->title ?></h5>
     <p class="card-text">Количество товаров: <?= $model->amount ?> </p>
     <p class="card-text">Сумма заказ: <?= $model->cost ?> Р </p>
     <div class="d-flex justify-content-end">
 
         <?= Html::a('Просмотреть заказ', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary'])?>
     </div>
   </div>
 </div>