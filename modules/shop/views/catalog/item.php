<?php

use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\helpers\Url;

?>
<div class="product-card text-center" data-url="<?= Url::to(['view', 'id' => $model->id]) ?>">
    <img src="<?= $model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg' ?>"
         class="product-card-img"
         alt="<?= Html::encode($model->title) ?>">

    <div class="product-card-body">
        <h5 class="product-title">
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id], ['class' => 'product-title-link']) ?>
        </h5>

        <div class="stock-badge mb-3">
            <i class="bi bi-check-circle-fill stock-icon"></i>
            <span class="stock-text">В наличии:</span>
            <span class="fw-bold stock-count mx-1"><?= $model->count ?></span>
            <span class="stock-text">шт.</span>
        </div>

        <div class="price-container mb-3">
            <?= Yii::$app->formatter->asDecimal($model->price, 2) ?>
            <span class="ruble-symbol">₽</span>
            <span class="product-volume"><?= $model->volume ?> мл</span>
        </div>

        <?php $avgRating = $model->getAverageRating(); ?>
        <?php if ($avgRating > 0): ?>
            <div class="product-rating-container-style mb-3">
                <div class="product-rating-style d-flex ">
                    <span><?= number_format($avgRating, 1) ?></span>
                    <?= StarRating::widget([
                        'name' => 'product-rating-style' . $model->id,
                        'value' => $avgRating,
                        'pluginOptions' => [
                            'size' => 'xs',
                            'readonly' => true,
                            'showClear' => false,
                            'showCaption' => false,
                            'hoverEnabled' => false,
                            'displayOnly' => true
                        ]
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="product-actions mt-auto">
            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('В корзину', ['/site/login'], [
                    'class' => 'btn btn-orange-style w-100 btn-add-cart',
                    'data-pjax' => 0,
                ]) ?>
            <?php elseif (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin): ?>
                <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
                    'class' => 'btn btn-orange-style w-100 btn-add-cart',
                    'data-pjax' => 0,
                ]) ?>
            <?php endif ?>
        </div>
    </div>
</div>