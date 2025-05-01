<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\modules\shop\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Главная';

?>
<div class="order-index">


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "<div class='d-flex gap-5 justify-content-center'>{items}</div>",
        'itemOptions' => ['class' => 'item'],
        'itemView' => "item",
    ]) ?>



</div>
