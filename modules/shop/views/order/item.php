<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

$photo = isset($model['product_photo']) ? '/img/' . $model['product_photo'] : '/img/no_photo.jpg';
?>

<div class="order-card">
    <div class="order-card-body">

        <div class="order-item d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="fs-4 fw-bold p-3">
                <?= ++$key ?>
            </div>
            <div class="order-item-image">
                <img src="<?= $photo ?>"
                     class="order-img"
                     alt="<?= Html::encode($model['product_title']) ?>">
            </div>

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

            <div class="order-item-price d-flex justify-content-end">
                <?= Yii::$app->formatter->asDecimal($model['product_price'], 2) ?> ₽
            </div>
        </div>

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