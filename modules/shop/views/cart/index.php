<?php

use app\models\Cart;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\shop\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h3><?= Html::encode($this->title) ?></h3>




    <?php Pjax::begin([
        'id' => 'cart-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?php if ($dataProvider->totalCount): ?>
        <div class="d-flex justify-content-end mb-3">
            <?= Html::a('Очистить корзину', ['clear', 'id' => $dataProvider->models[0]['cart_id']], ['class' => 'btn btn-danger btn-cart-clear', 'data-pjax' => "0"]) ?>
        </div>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'layout' => '{items}'
        ]) ?>
        <div class="d-flex justify-content-between gap-3 align-content-end">
            <div class="mt-3">
                <span>
                    Итого:
                    количество - <span class="fw-bold"><?= $dataProvider->models[0]['cart_amount'] ?></span>
                    сумма - <span class="fw-bold"><?= $dataProvider->models[0]['cart_cost'] ?></span>
                </span>
            </div>
            <?= Html::a('Оформить заказ', ['order/create', 'cart_id' => $dataProvider->models[0]['cart_id']], ['class' => 'btn btn-orange btn-order-create']) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-primary alert-cart-empty" role="alert">
            Ваша корзина пуста!
        </div>
    <?php endif ?>

    <?php Pjax::end(); ?>

</div>