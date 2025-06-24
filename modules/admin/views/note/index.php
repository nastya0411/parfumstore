<?php

use app\models\Note;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\NoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ноты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Назад', ['/admin/shop'], ['class' => 'btn btn-black-style']) ?>

        <?= Html::a('Создать ноту', ['create'], ['class' => ' btn btn-orange-style']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pager' => [
        'class' => \yii\bootstrap5\LinkPager::class
    ],
    'tableOptions' => [
        'class' => 'table table-bordered', // добавляет границы, если нужно
        'style' => 'background-color: white; color: black;'
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'title',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Note $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

    <?php Pjax::end(); ?>

</div>