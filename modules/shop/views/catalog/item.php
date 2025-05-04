<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

?>
<div class="card text-center product-card" style="width: 260px; height: 450px; cursor: pointer;" data-url="<?= Url::to(['view', 'id' => $model->id]) ?>">
  <img
    src="<?= $model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg' ?>"
    class="card-img-top"
    alt="<?= Html::encode($model->title) ?>"
    style="height: 250px; width: auto; object-fit: contain;">

  <div class="card-body">
    <div class="my-2 mb-3 ">
      <h4><?= Html::a($model->title, ['view', 'id' => $model->id],  ['class' => 'text-decoration-none']) ?></h4>
    </div>
    <div class="text-center my-2">
      <div class="d-inline-block bg-light rounded-pill">
        <i class="bi bi-check-circle-fill text-success me-1"></i>
        <span class="text-muted">В наличии:</span>
        <span class="fw-bold mx-1"><?= $model->count ?></span>
        <span class="text-muted">шт.</span>
      </div>
    </div>

    <div class="d-flex justify-content-center align-items-center fs-5 fw-bold gap-2">
      <?= Yii::$app->formatter->asDecimal($model->price, 2) ?> <span class="ruble-symbol">₽</span>
      <span><?= $model->volume ?> мл</span>
    </div>
    <div>
      <?= (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin)
        ? Html::a('В корзину', ['cart/add', 'id' => $model->id], [
          'class' => 'btn btn-outline-success w-100 btn-add-cart',
          'data-pjax' => 0,
        ])
        : "" ?>
    </div>
  </div>
</div>