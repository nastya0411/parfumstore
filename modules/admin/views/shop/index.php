<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

?>
<h3>Панель управления интернет-магазином</h3>
<p>
    <?= Html::a('Ноты', ['/admin/note'], ['class' => 'btn btn-outline-info']) ?>
    <?= Html::a('Категории', ['/admin/category'], ['class' => 'btn btn-outline-primary']) ?>
    <?= Html::a('Товары', ['/admin/product'], ['class' => 'btn btn-outline-success']) ?>
    <?= Html::a('Каталог', ['/shop'], ['class' => 'btn btn-outline-warning']) ?>

</p>