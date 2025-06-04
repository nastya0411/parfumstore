<?php

use app\models\Sex;
use app\models\StarsUser;
use kartik\rating\StarRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <div class="d-flex gap-3">
        <?= Html::a('Назад', $_SERVER['HTTP_REFERER'], ['class' => 'btn btn-black text-black']) ?>
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('В корзину', ['/site/login'], [
                'class' => 'btn btn-black btn-add-cart',
                'data-pjax' => 0,
            ]) ?>
        <?php elseif (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin): ?>
            <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
                'class' => 'btn btn-orange btn-add-cart w-5',
                'data-pjax' => 0,
            ])
            ?>
        <?php endif ?>
    </div>


    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
        <div class="alert alert-success alert-stars d-none">
            Рейтинг успешно поставлен!
        </div>
        <?php $form = ActiveForm::begin([]) ?>
        <?php $url = Url::to(["stars", "id" => $model->id]) ?>

        <?= $form->field($model, 'user_stars', ["options" => ["data-url" => $url]])
            ->label('Рейтинг товара')
            ->widget(StarRating::class, [
                'pluginOptions' => [
                    'readonly' => (bool)$stars,
                    'value' => $stars,
                    'showClear' => false,
                    'showCaption' => false,
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'hoverEnabled' => !(bool)$stars,
                    'displayOnly' => (bool)$stars,
                ],
            ]);
        ?>

       

       
</div>
<?php ActiveForm::end() ?>
<?php endif ?>

<?= $this->render("star-stat", ["model" => $model]) ?>
                          
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
            'value' => $model->volume,
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
<?php
$this->registerJsFile("/js/product.js", ["depends" => JqueryAsset::class]);
?>