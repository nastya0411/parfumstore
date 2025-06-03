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

    <footer id="footer" class="mt-auto py-3 bg-dark">

    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>