<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Товары категории: ' . Html::encode($category->title);

$this->registerCssFile('@web/css/product-cards.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
    'position' => \yii\web\View::POS_HEAD
]);
?>

<div class="category-products">
    <h1><?= $this->title ?></h1>

    
    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_product-card',
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'products-grid'],
        'itemOptions' => ['class' => 'product-card'],
    ]) ?>
</div>