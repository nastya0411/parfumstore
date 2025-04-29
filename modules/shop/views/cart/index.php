<?php

use app\models\Cart;
use yii\helpers\Html;
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

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin([
        'id' => 'cart-pjax',
        'enablePushState' => false,
        'timeout' => 5000,

    ]); ?>

    <? #php echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php if ($dataProvider->totalCount): ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'layout' => '{items}'
        ]) ?>


        <div class="d-flex justify-content-between gap-3">
            <div>
                <span>
                    Итого:
                    количество - <span class="fw-bold"><?= $dataProvider->models[0]['cart_amount'] ?></span>
                    сумма - <span class="fw-bold"><?= $dataProvider->models[0]['cart_cost'] ?></span>
                </span>
            </div>
            <?= Html::a('Очистить корзину', ['clear', 'id' => $dataProvider->models[0]['cart_id']], ['class' => 'btn btn-outline-danger btn-cart-clear']) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-primary" role="alert">
            Ваша корзина пуста!
        </div>

    <?php endif ?>

    <?php Pjax::end(); ?>

</div>