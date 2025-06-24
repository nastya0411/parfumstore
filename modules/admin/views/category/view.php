<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <p>
    <?= Html::a('Назад', ['/admin/category'], ['class' => 'btn btn-orange-style']) ?>
    </p>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-black-style']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-red-style',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить категорию?',
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
            [
                'label' => 'Изображение товара',
                'format' => 'html',
                'value' => function ($model) {
                    $photoPath = $model->getPhotos()->count() 
                        ? '/img/' . $model->photos[0]->photo 
                        : '/img/no_photo.jpg';
                    
                    return Html::img($photoPath, ['style' => 'max-width: 400px; height: auto;']);
                }
            ],
        ],
    ]) ?>
    

</div>
