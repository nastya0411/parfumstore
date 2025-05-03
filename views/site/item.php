<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Url::to(['/shop/category/products', 'id' => $model->id]) ?>" class="category-card">  
  <?php
  $categoryPhoto = !empty($model->photo)
      ? '/img/' . $model->photo
      : (!empty($model->photos[0]->photo)
          ? '/img/' . $model->photos[0]->photo
          : '/img/no_photo.jpg');
  ?>
  <img src="<?= $categoryPhoto ?>" class="card-img-top" alt="<?= Html::encode($model->title) ?>">
  <div class="card-body">
    <p class="card-text"><?= Html::encode($model->title) ?></p>
  </div>
</a>
