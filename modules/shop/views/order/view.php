<?php

use app\models\PayType;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Заказ № '.$model->id.' от '. 
Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s');
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'address',
            'phone',
            [
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s')
            ],
            [
                'attribute' => 'date',
                'value' => Yii::$app->formatter->asDate($model->date, 'php:d.m.Y')
            ],
            [
                'attribute' => 'time',
                'value' => Yii::$app->formatter->asTime($model->time, 'php:H:i')
            ],
            [
                'attribute' => 'pay_type_id',
                'value' => PayType::getPayTypes()[$model->pay_type_id]
            ],
            [
                'attribute' => 'status_id',
                'value' => Status::getStatuses()[$model->status_id]
            ],
            'amount',
            'cost',
            [
                'attribute' => 'other_reason',
                'value' => !empty($model->other_reason)
            ],
            // 'pay_receipt',
        ],
    ]) ?>
    <div>
        Состав заказа:
    </div>

    <?php foreach($model->orderItems as $item): ?>
        <?= $this->render('item-view', ['model' => $item])   ?>
    <?php endforeach ?>

</div>
