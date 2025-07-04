<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Note $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ноты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="note-view">
<p>
    <?= Html::a('Назад', ['/admin/note'], ['class' => 'btn btn-orange-style']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-black-style']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-red-style',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить ноту?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?= DetailView::widget([
    'model' => $model,
    'options' => [
        'class' => 'table table-bordered', // добавляет границы
        'style' => 'background-color: white; color: black;'
    ],
    'attributes' => [
        'id',
        'title',
    ],
]) ?>

</div>
