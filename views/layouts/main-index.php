<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

AppAsset::register($this);

// if (!Yii::$app->user->isGuest) {
//     if (Yii::$app->user->identity->isAdmin) {
//         $this->registerCssFile('@web/css/tw.css');
//     } else {
//         $this->registerCssFile('@web/css/tw.css');
//     }
// } else {
//     $this->registerCssFile('@web/css/site.css');
// }

$this->registerCsrfMetaTags();

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/favicon4.png')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100 ">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100 bg-black text-white">
    <?php $this->beginBody() ?>

    <?= $this->render("header") ?>

    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
        <div class="alert alert-danger alert-count">
            Максимальное количество товара уже в корзине!
        </div>
    <?php endif ?>
    <main id="main" class="flex-shrink-0" role="main">
        <?= $content ?>
    </main>

    <footer id="footer">
        <div class="container py-5">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
                <nav class="footer-nav d-flex flex-wrap gap-4">
                    <?= Html::a('Главная', ['/site/index'], ['class' => 'footer-link']) ?>
                    <?= Html::a('О нас', ['/site/about'], ['class' => 'footer-link']) ?>
                    <?= Html::a('Каталог', ['/shop'], ['class' => 'footer-link']) ?>
                </nav>

                <div class="footer-contacts">
                    Контакты: <br>
                    <?= Html::a('+7 928 282-82-82', 'tel:+79282828282', ['class' => 'footer-contact-link']) ?> <br>
                    <?= Html::a(
                        'parfumstore_info@mail.ru',
                        'https://e.mail.ru/compose/?mailto=parfumstore_info@mail.ru',
                        ['class' => 'footer-contact-link', 'target' => '_blank', 'rel' => 'noopener noreferrer']
                    ) ?>
                </div>
            </div>

            <div class="footer-copyright">2025 Mon Parfum. Все права защищены</div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>