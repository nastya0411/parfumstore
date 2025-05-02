<?php
 
 use yii\bootstrap5\Html;
 
 /** @var yii\web\View $this */
 /** @var app\models\Application $model */
 
 $this->title = 'Причина отмены заказа: ' . $model->id . ' от '.
Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y. H:i.s');
 $this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
 $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
 $this->params['breadcrumbs'][] = 'Отмена';
 ?>
 <div class="application-update">
 
     <h1><?= Html::encode($this->title) ?></h1>
 
     <?= $this->render('_form', [
         'model' => $model,
     ]) ?>
 
 </div>