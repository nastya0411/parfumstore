<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Создание заказа';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="d-flex justify-content-end gap-3 fs-4 my-3">
        <div>
            <span>
                Итого:
                количество - <span class="fw-bold"><?= $dataProvider->models[0]['cart_amount'] ?></span>
                сумма - <span class="fw-bold"><?= $dataProvider->models[0]['cart_cost'] ?></span>
            </span>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
        'layout' => '{items}'
    ]) ?>

    <div class="d-flex justify-content-end gap-3 fs-4 my-3">
        <div>
            <span>
                Итого:
                количество - <span class="fw-bold"><?= $dataProvider->models[0]['cart_amount'] ?></span>
                сумма - <span class="fw-bold"><?= $dataProvider->models[0]['cart_cost'] ?></span>
            </span>
        </div>
    </div>



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>