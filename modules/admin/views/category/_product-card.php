<?php
use yii\bootstrap5\Html;
use yii\helpers\Url;
?>

<div class="pc-card text-center" data-url="<?= Url::to(['view', 'id' => $model->id]) ?>">
    <img src="<?= $model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg' ?>"
         class="pc-card-img-top"
         alt="<?= Html::encode($model->title) ?>">

    <div class="pc-card-body">
        <div class="pc-title-container">
            <h4 class="pc-product-title"><?= Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'pc-product-title-link']) ?></h4>
        </div>
        
        <div class="text-center pc-stock-container">
            <div class="pc-stock-badge">
                <i class="bi bi-check-circle-fill pc-stock-icon"></i>
                <span class="pc-stock-text">В наличии:</span>
                <span class="pc-stock-count"><?= $model->count ?></span>
                <span class="pc-stock-text">шт.</span>
            </div>
        </div>

        <div class="pc-price-container">
            <?= Yii::$app->formatter->asDecimal($model->price, 2) ?>
            <span class="pc-ruble-symbol">₽</span>
            <span class="pc-volume"><?= $model->volume ?> мл</span>
        </div>

        <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
            <div class="pc-cart-btn-container">
                <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
                    'class' => 'btn btn-outline-success pc-cart-btn',
                    'data-pjax' => 0,
                ]) ?>
            </div>
        <?php elseif (Yii::$app->user->isGuest): ?>
            <div class="pc-cart-btn-container">
                <?= Html::a('В корзину', ['site/login'], [
                    'class' => 'btn btn-outline-success pc-cart-btn',
                    'data' => [
                        'method' => 'post',
                        'params' => ['returnUrl' => Yii::$app->request->url],
                    ],
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</div>