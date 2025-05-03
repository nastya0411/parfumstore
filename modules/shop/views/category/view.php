<?php

use app\models\Sex;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <p>
        <?= Html::a('Назад', ['/shop/category/index'], ['class' => 'btn btn-outline-info']) ?>
    </p>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'count',
                'value' => function ($model) {
                    return "В наличии: {$model->count} шт.";
                },
            ],
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDecimal($model->price, 2) . ' р.';
                },
            ],
            [
                'attribute' => 'volume',
                'value' => function($model) {
                    return isset($model->volume) ? $model->volume . ' мл' : 'Не указан';
                },
            ],
            [
                'attribute' => 'sex_id',
                'value' => Sex::getSexes()[$model->sex_id]
            ],
            'description:html',
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