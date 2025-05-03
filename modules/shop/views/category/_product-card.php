<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Product $model */
?>

<div class="product-card" data-url="<?= Url::to(['view', 'id' => $model->id]) ?>">
    <img src="<?= $model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg' ?>"
         class="product-card-img"
         alt="<?= Html::encode($model->title) ?>">

    <div class="product-card-body">
        <h4 class="product-title">
            <?= Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'product-title-link']) ?>
        </h4>
        
        <div class="stock-badge">
            <i class="bi bi-check-circle-fill stock-icon"></i>
            <span class="stock-text">В наличии:</span>
            <span class="stock-count"><?= $model->count ?></span>
            <span class="stock-text">шт.</span>
        </div>
        
        <div class="price-container">
            <?= Yii::$app->formatter->asDecimal($model->price, 2) ?>
            <span class="ruble-symbol">₽</span>
            <span class="product-volume"><?= $model->volume ?> мл</span>
        </div>
        
        <div class="product-actions">
            <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin): ?>
                <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
                    'class' => 'btn btn-outline-success btn-add-cart',
                    'data-pjax' => 0,
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>