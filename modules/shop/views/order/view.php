<?php

use app\models\PayType;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Заказ № ' . $model->id . ' от ' .
    Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s');
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-start gap-2">
        <?= Html::a('Назад', (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin)
            ? ['/admin']
            : ['index'], ['class' => 'btn btn-outline-info']) ?>

        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->getIsAdmin()): ?>
            <?= $model->status_id == Status::getStatusId('Оплачен оффлайн')
                ? Html::a('Выдача заказа', ['apply', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Создан')
                ? Html::a('В сборку', ['work', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ]) .
                Html::a('Отменен', ['cancel', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Оплачен онлайн')
                ? Html::a('В сборку', ['work', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ]) .
                Html::a('Отменен', ['cancel', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Ожидает оплаты')
                ? Html::a('Отменен', ['cancel', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data-method' => 'post',
                    'data-pjax' => 1
                ])
                : ''
            ?>

            <?php
            if ($model->status_id == Status::getStatusId('В сборке')) {
                echo $model->pay_receipt
                    ? Html::a('Оплата при получении', ['paid', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ])
                    : Html::a('Доставлен', ['apply', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ]);
            }
            ?>
        <?php endif; ?>
    </div>
</div>



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
        // [
        //     'attribute' => 'pay_type_id',
        //     'value' => PayType::getPayTypesOnline()[$model->pay_type_id]
        // ],
        [
            'attribute' => 'status_id',
            'value' => Status::getStatuses()[$model->status_id]
        ],
        'amount',
        'cost',
        [
            'attribute' => 'other_reason',
            'format' => 'ntext',
            'value' => $model->other_reason,
            'visible' => (bool)$model->other_reason,

        ],


        // 'pay_receipt',
    ],
]) ?>
<div>
    Состав заказа:
</div>

<?php Yii::debug($model) ?>
<?php foreach ($model->orderItems as $item): ?>
    <?= $this->render('item-view', ['model' => $item])   ?>
<?php endforeach ?>

</div>