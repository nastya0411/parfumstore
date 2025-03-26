<?php
 
 use yii\helpers\Html;
 use yii\widgets\DetailView;
 
 /** @var yii\web\View $this */
 /** @var app\models\Application $model */
 
 $this->title = '№' . $model->id . ' от ' .  Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
 $this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
 $this->params['breadcrumbs'][] = $this->title;
 \yii\web\YiiAsset::register($this);
 ?>
 <div class="application-view">
 
     <h3><?= Html::encode($this->title) ?></h3>
 
     <p>
         <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-primary']) ?>        
     </p>
 
     <?= DetailView::widget([
         'model' => $model,
         'attributes' => [
             'id',
             'created_at',
             [
                 'attribute' => 'user_id',
                 'value' => $model->user->full_name,
             ],            
             
             [
                 'label' => 'Дата и время заказа',
                 'value' => Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time,
             ],
             
             //'other',
 
             'address',
             'phone',
             [
                 'attribute' => 'pay_type_id',
                 'value' => $model->payType->title,
             ],
             
             [
                 'attribute' => 'status_id',
                 'value' => $model->status->title,
             ],
 
 
         ],
     ]) ?>
 
 </div>