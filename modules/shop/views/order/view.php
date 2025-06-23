<?php

use app\models\PayType;
use app\models\Status;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->registerCssFile('@web/css/view-style.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);

$this->title = 'Заказ № ' . $model->id . ' от ' .
    Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s');
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$sum = 0;
?>
<div class="order-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-start gap-2 ">

        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if (Yii::$app->user->identity->getIsAdmin()): ?>
                <?= Html::a('Назад', ['/admin'], ['class' => 'btn btn-black-style mb-3']) ?>
                <?= $model->status_id == Status::getStatusId('Оплачен оффлайн')
                    ? Html::a('Выдача заказа', ['apply', 'id' => $model->id], [
                        'class' => 'btn btn-black text-black',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ])
                    : ''
                ?>

                <?= $model->status_id == Status::getStatusId('Создан')
                    ? Html::a('В сборку', ['work', 'id' => $model->id], [
                        'class' => 'btn btn-black text-black',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ]) .
                    Html::a('Отменен', ['cancel', 'id' => $model->id], [
                        'class' => 'btn btn-black text-black',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ])
                    : ''
                ?>

                <?= $model->status_id == Status::getStatusId('Оплачен онлайн')
                    ? Html::a('В сборку', ['work', 'id' => $model->id], [
                        'class' => 'btn btn-black text-black',
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
                        'class' => 'btn btn-black black',
                        'data-method' => 'post',
                        'data-pjax' => 1
                    ])
                    : ''
                ?>

                <?php
                if ($model->status_id == Status::getStatusId('В сборке')) {
                    echo $model->pay_receipt
                        ? Html::a('Оплата при получении', ['paid', 'id' => $model->id], [
                            'class' => 'btn btn-black text-black',
                            'data-method' => 'post',
                            'data-pjax' => 1
                        ])
                        : Html::a('Доставлен', ['apply', 'id' => $model->id], [
                            'class' => 'btn btn-black text-orange',
                            'data-method' => 'post',
                            'data-pjax' => 1
                        ]);
                }
                ?>
            <?php else: ?>
                <?= Html::a('Назад', ['/account'], ['class' => 'btn btn-black-style mb-3']) ?>
            <?php endif; ?>
        <?php endif; ?>


    </div>
</div>

<div class=" text-black detail-view-container">
    <?= DetailView::widget([
        'options' => ['class' => 'detail-view table-borderless'],
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
                'attribute' => 'status_id',
                "format" => "html",
                'value' => "<div class='d-flex gap-3 align-items-center'>"
                    . Status::getStatuses()[$model->status_id]
                    . ($model->payType->isQR &&
                        Status::getStatusId("Оплачен онлайн") != $model->status_id
                        ? Html::a('Оплатить по QR', ['qr-payment', "id" => $model->id], ['class' => 'btn btn-orange-style'])
                        : "")
                    . "</div>",
            ],
            'amount',
            'cost',
            [
                'attribute' => 'other_reason',
                'format' => 'ntext',
                'value' => $model->other_reason,
                'visible' => (bool)$model->other_reason,
            ],
        ],
    ]) ?>
</div>

<div class="mt-4 ml-5">
    Состав заказа:
</div>


<?php foreach ($model->orderItems as $key => $item): ?>
    <?php $sum += $item->cost ?>
    <?= $this->render('item-view', ['model' => $item, "key" => $key]) ?>
<?php endforeach ?>

<div class="border-white border-top border-2 py-3 order-total fw-bold fs-3 ">
    <div class="row">
        <div class="offset-1 col-1">
            Итого: 
        </div>
        <div class="offset-7 col-3">
            <?= Yii::$app->formatter->asDecimal($sum, 2) ?> ₽
        </div>

    </div>
</div>

