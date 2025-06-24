<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$url = urlencode("https://" . $_SERVER['HTTP_HOST'] . Url::to(["order/qr-payment-end", "id" => $model->id]));

$url = "https://api.qrserver.com/v1/create-qr-code/?data=$url&size=250x250";
?>

<div class="d-flex flex-column justify-content-center align-content-center m-auto border border-1 p-3 border-warning" style=" width: 300px; --bs-border-opacity: .8; transition: all 1s ease">
    <div class="mb-3">
        Заказ №<?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->created_at, "php:d.m.Y") ?>
    </div>

    <div class="text-warning fw-bold fs-3 text-center">
        Заказ успешно оплачен.
    </div>
</div>