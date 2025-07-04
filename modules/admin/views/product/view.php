<?php

use app\models\Sex;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <p>
        <?= Html::a('Назад', ['/admin/product'], ['class' => 'btn btn-orange-style']) ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-black-style']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-red-style',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить товар?',
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
            'price',
            'volume',
            'description:html',
            [
                'attribute' => 'sex_id',
                'value' => Sex::getSexes()[$model->sex_id]
            ],
            'count',

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
            [
                'label' => 'Категории товара',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->getProductCategories()->count()) {
                        $categories = [];
                        foreach ($model->productCategories as $val) {
                            $categories[] = $val->category->title;
                        }
                        return implode(', ', $categories);
                    }
                    return '-';
                }
            ],
            [
                'label' => 'Ноты',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    $productNoteLevels = $model->productNoteLevels;
                    $levels = [];
                    foreach ($productNoteLevels as $productNoteLevel) {
                        $levelName = $productNoteLevel->noteLevel->title;
                        $notes = [];

                        foreach ($productNoteLevel->productNoteLevelItems as $item) {
                            $notes[] = $item->note->title;
                        }

                        if (!empty($notes)) {
                            $levels[$levelName] = implode(', ', $notes);
                        }
                    }

                    foreach (['Верхние ноты', 'Средние ноты', 'Базовые ноты'] as $level) {
                        if (isset($levels[$level])) {
                            $html .= "<div><strong>{$level}:</strong> {$levels[$level]}</div>";
                        }
                    }

                    return $html ?: '-';
                }
            ],
        ],
    ]) ?>

</div>