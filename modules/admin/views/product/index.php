<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Назад', ['/admin/shop'], ['class' => 'btn btn-black-style']) ?>

        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-orange-style']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'tableOptions' => [
        'class' => 'table table-bordered', // добавляет границы, если нужно
        'style' => 'background-color: white; color: black;'
    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'price',
            'sex_id',
            'count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>