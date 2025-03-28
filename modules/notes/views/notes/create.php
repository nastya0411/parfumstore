<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Notes $model */

$this->title = 'Добавить ноты';
$this->params['breadcrumbs'][] = ['label' => 'Ноты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'props' => $props,
        ]) ?>

</div>
