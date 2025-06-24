<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

?>
<h3>Панель управления интернет-магазином</h3>
<p>
    <?= Html::a('Ноты', ['/admin/note'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('Категории', ['/admin/category'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('Товары', ['/admin/product'], ['class' => 'btn btn-orange-style']) ?>
    <?= Html::a('Статистика', ['/admin/statistics'], ['class' => 'btn btn-orange-style']) ?>

</p>