<?php

use app\models\Sex;
use app\models\StarsUser;
use kartik\rating\StarRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
$this->registerCssFile('@web/css/product.css', ['depends' => [\yii\web\YiiAsset::class, \yii\bootstrap5\BootstrapAsset::class]]);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?= Html::a('Назад', $_SERVER['HTTP_REFERER'], ['class' => 'btn btn-outline-light']) ?>
    </div>

    <div class="container mt-4">
        <div class="row g-5">
            <div class="col-md-6 product-image">
                <?= Html::img($model->getPhotos()->count() ? '/img/' . $model->photos[0]->photo : '/img/no_photo.jpg', [
                    'class' => 'img-fluid rounded shadow-sm',
                    'alt' => 'Фото товара',
                ]) ?>
            </div>

            <div class="col-md-6 product-info">
                <h1 class="product-title-style"><?= Html::encode($this->title) ?></h1>

                <p class="product-description lead">
                    <?= $model->description ?>
                </p>

                <div class="product-price h2 text-orange mb-3">
                    <?= Yii::$app->formatter->asDecimal($model->price, 2) ?> ₽
                </div>

                <div class="mb-4">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('В корзину', ['/site/login'], [
                            'class' => 'btn btn-add-cart btn-outline-light w-100 py-2',
                            'data-pjax' => 0,
                        ]) ?>
                    <?php elseif (!Yii::$app->user->isGuest && !Yii::$app->user->identity?->isAdmin): ?>
                        <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], [
                            'class' => 'btn btn-orange btn-add-cart w-100 py-2',
                            'data-pjax' => 0,
                        ]) ?>
                    <?php endif ?>
                </div>



                <div class="additional-info">
                    <ul class="list-unstyled">
                        <li><strong>В наличии:</strong> <?= $model->count ?> шт.</li>
                        <li><strong>Объем:</strong> <?= $model->volume ?></li>
                        <li><strong>Пол:</strong> <?= Sex::getSexes()[$model->sex_id] ?></li>
                        <li><strong>Категории:</strong>
                            <?php
                            if ($model->getProductCategories()->count()) {
                                $categories = [];
                                foreach ($model->productCategories as $val) {
                                    $categories[] = $val->category->title;
                                }
                                echo implode(', ', $categories);
                            } else {
                                echo '-';
                            }
                            ?>
                        </li>
                        <li><strong>Ноты:</strong>
                            <?php
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

                            echo $html ?: '-';
                            ?>
                        </li>
                    </ul>
                </div>
                <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                    <div class="rating-block rating-block p-3 rounded mb-4">
                        <div class="alert alert-success alert-stars d-none text-center">
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
                        <?php ActiveForm::end() ?>

                        <?= $this->render("star-stat", ["model" => $model]) ?>
                    </div>
                <?php else: ?>
                    <?= $this->render("star-stat", ["model" => $model]) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile("/js/product.js", ["depends" => JqueryAsset::class]);
?>