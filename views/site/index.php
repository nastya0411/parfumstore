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
  <div class="custom-categories-wrapper"> 
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "<div class='categories-grid'>{items}</div>",
        'itemOptions' => ['class' => 'item'],
        'itemView' => "item",
    ]) ?>
  </div>
</div>

<?php 
$this->registerCssFile('@web/css/caregory-card.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
    'position' => \yii\web\View::POS_END
]);
?>