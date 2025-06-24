<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

// Подключаем CSS файл
$this->registerCssFile('@web/css/view-style.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class]
]);

$photo = isset($model['product_photo']) ? '/img/' . $model['product_photo'] : '/img/no_photo.jpg';
?>

<div class="order-card">
    <div class="order-card-body">

        <!-- Блок с информацией о товаре -->
        <div class="order-item d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="fs-4 fw-bold p-3">
                <?= ++$key ?>
            </div>           
            <div class="order-item-image">
                <?= Html::img($photo, [
                    'alt' => Html::encode($model['product_title']),
                    'class' => 'order-img',
                ]) ?>
            </div>

            <!-- Название товара и объем -->
            <div class="order-item-details text-center flex-fill">
                <?= Html::a(
                    Html::encode($model['product_title']),
                    ['/shop/catalog/view', 'id' => $model['product_id']],
                    ['class' => 'text-decoration-none order-title d-block']
                ) ?>
                <div class="order-volume my-2 fw-bold d-block">
                    <?= $model['product_volume'] ?> мл
                </div>
            </div>

            <!-- Цена за единицу + кнопки +/- и удалить -->
                <div class="order-item-price fs-5 fw-bold">
                    <?= Yii::$app->formatter->asDecimal($model['product_price'], 2) ?> ₽
                </div>

                <div class="d-flex gap-2">
                    <?= Html::a('-', ['item-del', 'id' => $model['product_id']], ['class' => 'btn btn-black-style btn-item-del']) ?>
                    <span class='fs-4 text-white px-2'><?= $model['item_amount'] ?></span>
                    <?= Html::a('+', ['add', 'id' => $model['product_id']], ['class' => 'btn btn-orange-style btn-item-add']) ?>
                    <?= Html::a('Удалить', ['item-remove', 'id' => $model['item_id']], ['class' => 'btn btn-red-style btn-item-remove 
                ']) ?>
                </div>
            </div>

        <!-- Блок с количеством и общей суммой ПОСЛЕ разделителя -->
        <div class="order-summary d-flex justify-content-between mt-3 pt-3 border-top">
            <div>
                Количество:
                <span class="fw-bold ms-1"><?= $model['item_amount'] ?></span>
                <span class="ms-1">шт.</span>
            </div>
            <div class="order-total fw-bold fs-4">
                <?= Yii::$app->formatter->asDecimal($model['item_cost'], 2) ?> ₽
            </div>
        </div>

    </div>
</div>