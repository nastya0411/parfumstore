<?php

use app\models\Product;
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\modules\shop\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Главная';
$this->registerCssFile('@web/css/products-carousel.css', [
  'depends' => [\yii\bootstrap5\BootstrapAsset::class],
  'position' => \yii\web\View::POS_HEAD
]);

$products = Product::find()
  ->where(['>', 'count', 0])
  ->limit(8)
  ->orderBy(['stars' => SORT_DESC])
  ->all();


$productChunks = array_chunk($products, 4);
?>


<div class="bg-block">
  <div class="left-rectangle justify-content-center text-center">
    <div>Ощути гармонию <br>и роскошь</div>
    <div>Mon parfum - твой личный проводник в мир изысканных араматов</div>
    <?= Html::a(
      Html::submitButton('Каталог', ['class' => 'btn']),
      ['/shop'],
      ['class' => 'text-decoration-none']
    ) ?>

  </div>
  <?= Html::img('@web/img/bottleMain.png', [
    'class' => 'overlay-photo',
  ]) ?>
</div>

<div class="container d-lg-block  d-none">
  <div id="productTop8" class="carousel slide " data-bs-ride="carousel">
    <h1 class="title-style text-center">Хиты продаж</h1>
    <div class="carousel-inner">
      <?php foreach ($productChunks as $index => $chunk): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <div class="d-flex justify-content-between">
            <?php foreach ($chunk as $product): ?>
              <div class="item my-3 col-md-3 col-sm-6 mb-4" data-key="<?= $product->id ?>">
                <div class="card text-center product-card" data-url="<?= Url::to(['/shop/catalog/view', 'id' => $product->id]) ?>" data-url-back="/">
                  <img src="<?= $product->getPhotos()->count() ? '/img/' . $product->photos[0]->photo : '/img/no_photo.jpg' ?>"
                    class="card-img-top"
                    alt="<?= Html::encode($product->title) ?>">

                  <div class="card-body">
                    <div class="my-2 mb-3">
                      <h4><?= Html::a($product->title, ['/shop/catalog/view', 'id' => $product->id], ['class' => 'text-decoration-none']) ?></h4>
                    </div>

                    <div class="availability-pill">
                      <i class="bi bi-check-circle-fill text-success me-1"></i>
                      <span class="text-muted">В наличии:</span>
                      <span class="fw-bold mx-1"><?= $product->count ?></span>
                      <span class="text-muted">шт.</span>
                    </div>

                    <div class="price-volume">
                      <?= Yii::$app->formatter->asDecimal($product->price, 2) ?>
                      <span class="ruble-symbol">₽</span>
                      <span><?= $product->volume ?> мл</span>
                    </div>


                    <?php $num_stars = (float)$product->stars ?>
                    <?php if ($num_stars): ?>
                      <div class="product-rating-container">
                        <div class="product-rating">
                          <span><?= $num_stars ?></span>
                          <?= StarRating::widget([
                            'name' => 'product-rating-' . $product->id,
                            'value' => $num_stars,
                            'pluginOptions' => [
                              'size' => 'xs',
                              'readonly' => true,
                              'showClear' => false,
                              'showCaption' => false,
                              'hoverEnabled' => false,
                              'displayOnly' => true
                            ]
                          ]) ?>
                        </div>
                      </div>
                    <?php endif ?>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productTop8" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productTop8" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>


<div class="about-main-grid">
  <img src="/web/img/bottleAbout2.png" class="about-grid-image">

  <div class="image-about-container text-center">
    <img src="/web/img/VectorAbout1.png" class="about-grid-image">
    <div class="image-about">
      <h1 class="">О нас</h1>
      <p>Mon Parfum - ваш источник роскошных ароматов и непревзойденного качества!</p>
      <p>Мы гордимся тем, что предлагаем только самые изысканные ароматы. Каждая бутылочка наполнена не
         только элегантностью и стилем, но и неповторимым шармом, способным подчеркнуть вашу уникальность!</p>
    </div>
  </div>
</div>

<div class="bg-meeting">
  <div class="meeting-style justify-content-center text-center" >
    <div>
      Познакомтесь с миром ароматов
    </div>
    <div>
      Добро пожаловать в Mon parfum, где дух победы и триумфа оживает благодаря ароматам, которые придают силы и
      вдохновляют. Наша коллекции - это праздник успеха, призванный раскрыть вашу победоносную сущность. Насладитесь
      сладким вкусом триумфа с пленительными ароматами, рассказывающими о ваших достижениях. <br> В Mon parfum мы считаем,
      что каждая победа заслуживает фирменного аромата, и мы стремимся создавать незабываемые ароматы, которые поднимут
      ваш дух и придадут сил вашему путешествию.
    </div>
  </div>
</div>


<div class="order-index">
  <h1 class="title-style text-center mt-4">Категории ароматов</h1>
  <div class="custom-categories-wrapper">
    <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'layout' => "<div class='categories-grid '>{items}</div>",
      'itemOptions' => ['class' => 'item'],
      'itemView' => "item",
    ]) ?>
  </div>
</div>

<?php
$this->registerCssFile('@web/css/caregory-card.css', [
  'depends' => [\yii\bootstrap5\BootstrapAsset::class],
  'position' => \yii\web\View::POS_END
]);


$this->registerJsFile("/js/product.js", ["depends" => JqueryAsset::class]);
?>