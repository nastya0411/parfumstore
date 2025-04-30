<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

$photo = isset($model['product_photo']) ? '/img/' . $model['product_photo'] : '/img/no_photo.jpg';
?>

<div class="card mb-3">
    <!-- <h5 class="card-header fw-bold"><? #= Html::encode($model['product_title']) 
                                            ?></h5> -->
    <div class="card-body">
        <!-- <h5 class="card-title">Состав вашей корзины</h5> -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <img src="<?= $photo ?>"
                    class="card-img-top"
                    alt="<?= Html::encode($model['product_title']) ?>"
                    style="height: 80px; width: auto; object-fit: contain;">
            </div>
            <div class="card-text d-flex flex-column align-items-center text-center">
                <?= Html::a(
                    Html::encode($model['product_title']),
                    ['/shop/catalog/view', 'id' => $model['product_id']],
                    ['class' => 'text-decoration-none']
                ) ?>
                <div class="my-2 fs-8 fw-bold">
                    <?= $model['product_volume'] ?> мл
                </div>
            </div>

            <div class="my-2 fs-4 fw-bold">
                <?= Yii::$app->formatter->asDecimal($model['product_price'], 2) ?> ₽
            </div>
        </div>

        <div class="d-flex justify-content-between gap-3 mt-3">
            <div>
                <span>
                    Итого:
                    количество - <span class="fw-bold"><?= $model['item_amount'] ?></span>
                    сумма - <span class="fw-bold"><?= Yii::$app->formatter->asDecimal($model['item_cost'], 2) ?> ₽</span>
                </span>
            </div>
        </div>
    </div>
</div>