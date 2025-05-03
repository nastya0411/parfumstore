<?php

use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = 'Товары категории';

$category = \app\models\Category::findOne($categoryId);
$this->title = 'Товары категории: ' . Html::encode($category->title);
?>

<h1><?= $this->title ?></h1>

<div class="categories-grid">
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_product-card', ['model' => $model]);
    },
    'layout' => "<div class='categories-grid'>{items}</div>{pager}",
]) ?>
</div>