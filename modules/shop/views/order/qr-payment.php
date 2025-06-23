<?php

use yii\helpers\Url;
use yii\web\JqueryAsset;

$url = urlencode("https://" . $_SERVER['HTTP_HOST'] . Url::to(["order/qr-payment-end", "id" => $model->id]));

$url = "https://api.qrserver.com/v1/create-qr-code/?data=$url&size=250x250";
?>
<div class="d-none alert alert-danger m-5" style="transition: all 1s ease" role="alert">
    Время заказа истекло.
</div>

<div class="d-flex flex-column justify-content-center align-content-center m-auto border border-1 p-3 border-orange-style text-white"
 style=" width: 300px; --bs-border-opacity: .8; transition: all 1s ease">
    <div class="mb-3">
        Зазак №<?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->created_at, "php:d.m.Y") ?>
    </div>
    <div class="mb-3">
        Для оплаты<br>отсканируйте QR-код
    </div>
    <div class="text-center ">
        <div class="qr mb-3 mx-auto" class="" style="height: 250px; width: 250px; background-image: url('<?= $url ?>')" />
    </div>

    <div class="timer text-center">
        До конца оплаты осталось:
        <div class="timer-value  text-orange fw-bold fs-3">
            1:00
        </div>
    </div>
</div>



<?php
$this->registerJsFile("/js/qr-code.js", ["depends" => JqueryAsset::class]);
