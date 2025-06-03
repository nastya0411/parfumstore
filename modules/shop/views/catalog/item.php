<?php
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->registerCssFile('/css/cart.css');
?>
<div class="card text-center product-card" data-url="<?= Url::to(['view', 'id' => $model->id]) ?>">
  <img src="<?= $model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg' ?>"
       class="card-img-top"
       alt="<?= Html::encode($model->title) ?>">

  <div class="card-body">
    <div class="my-2 mb-3">
      <h4><?= Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'text-decoration-none']) ?></h4>
    </div>
    
    <div class="availability-pill">
      <i class="bi bi-check-circle-fill text-success me-1"></i>
      <span class="text-muted">В наличии:</span>
      <span class="fw-bold mx-1"><?= $model->count ?></span>
      <span class="text-muted">шт.</span>
    </div>

    <div class="price-volume">
      <?= Yii::$app->formatter->asDecimal($model->price, 2) ?>
      <span class="ruble-symbol">₽</span>
      <span><?= $model->volume ?> мл</span>
    </div>
    
    <?php $avgRating = $model->getAverageRating(); ?>
    <?php if ($avgRating > 0): ?>
      <div class="product-rating-container">
        <div class="product-rating">
          <span><?= number_format($avgRating, 1) ?></span>
          <?= StarRating::widget([
            'name' => 'product-rating-' . $model->id,
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
    
    <div class="cart-button-container">
      <?php if (Yii::$app->user->isGuest): ?>
        <?= Html::a('В корзину', ['/site/login'], [
          'class' => 'btn btn-orange w-100 btn-add-cart',
          'data-pjax' => 0,
        ]) ?>
      <?php elseif (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin): ?>
        <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
          'class' => 'btn-orange  w-100 btn-add-cart',
          'data-pjax' => 0,
        ]) ?>
      <?php endif ?>
    </div>
  </div>
</div>