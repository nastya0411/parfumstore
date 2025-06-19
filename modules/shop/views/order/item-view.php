<?php

use yii\bootstrap5\Html;


$photo = isset($model->product->photo) ? '/img/' . $model->product->photo : '/img/no_photo.jpg';
?>

<div class="card mb-3 text-black">
    <h5 class="card-header fw-bold"><? $model->product->title ?></h5>
    <div class="card-body">
        <!-- <h5 class="card-title">Состав вашей корзины</h5> -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <img src="<?= $photo ?>"
                    class="card-img-top"
                    alt="<?= Html::encode($model->product->title) ?>"
                    style="height: 80px; width: auto; object-fit: contain;">
            </div>
            <div class="card-text d-flex flex-column align-items-center text-center">
                <?= Html::a(
                    Html::encode($model->product->title),
                    ['/shop/catalog/view', 'id' => $model->product->id],
                    ['class' => 'text-decoration-none']
                ) ?>
                <div class="my-2 fs-8 fw-bold">
                    <?= $model->product->volume ?> мл
                </div>
            </div>

            <div class="my-2 fs-4 fw-bold">
                <?= Yii::$app->formatter->asDecimal($model->product->price, 2) ?> ₽
            </div>
        </div>

        <div class="d-flex justify-content-between gap-3 mt-3">
            <div>
                <span>
                    Итого:
                    количество - <span class="fw-bold"><?= $model->amount ?></span>
                    сумма - <span class="fw-bold"><?= Yii::$app->formatter->asDecimal($model->cost, 2) ?> ₽</span>
                </span>
            </div>
        </div>
    </div>
</div>