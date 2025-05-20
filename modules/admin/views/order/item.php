<?php

use app\models\Status;
use yii\bootstrap5\Html;

?>

<div class="card mb-4">
    <div class="card-header fw-semibold fs-5">
        № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
        <h5 class="card-title">Клиент: <?= $model->user->full_name ?></h5>
    </div>
    <div class="card-body">
        <h5 class="card-title text-decoration-underline">Дата и время получения заказа: <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') . ' ' . $model->time ?></h5>
        <h5 class="card-title">Статус заказа: <?= $model->status->title ?></h5>
        <p class="card-text">Количество товаров: <?= $model->amount ?> </p>
        <p class="card-text">Сумма заказа: <?= $model->cost ?> Р </p>
        <div class="d-flex justify-content-start gap-2">

            <?= $model->status_id == Status::getStatusId('Оплачен оффлайн')
                ? Html::a('Выдача заказа', ['apply', 'id' => $model->id], ['class' =>
                'btn btn-outline-primary', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>


            <?= $model->status_id == Status::getStatusId('Создан')
                ? Html::a('В сборку', ['work', 'id' => $model->id], ['class' =>
                'btn btn-outline-primary', 'data-method' => 'post', 'data-pjax' => 0])
                . Html::a('Отмененить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-outline-danger', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Оплачен онлайн')
                ? Html::a('В сборку', ['work', 'id' => $model->id], ['class' =>
                'btn btn-outline-primary', 'data-method' => 'post', 'data-pjax' => 0])
                . Html::a('Отмененить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-outline-danger', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Ожидает оплаты')
                ? Html::a('Отмененить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-outline-danger', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?php
            $btn = "";
            if ($model->status_id == Status::getStatusId('В сборке')) {
                if ($model->pay_receipt) {
                    $btn = Html::a('Оплата при получении', ['paid', 'id' => $model->id], ['class' => 'btn btn-outline-success', 'data-method' => 'post', 'data-pjax' => 0]);
                } else {
                    $btn = Html::a('Доставлен', ['apply', 'id' => $model->id], ['class' => 'btn btn-outline-success', 'data-method' => 'post', 'data-pjax' => 0]);
                }
            }
            echo $btn;
            ?>



            <?= Html::a('Просмотреть заказ', ['/shop/order/view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        </div>

    </div>
</div>