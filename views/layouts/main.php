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

    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
        <div class="alert alert-danger alert-count">
            Максимальное количество товара уже в корзине!
        </div>
    <?php endif ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => 'Mon parfum',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-black fixed-top'],
            'collapseOptions' => [
                'class' => 'navbar-collapse collapse',
            ],

        ]);


        // echo Nav::widget([
        //     'options' => ['class' => 'nav-my '],
        //     'items' => [
        //         Yii::$app->user->isGuest
        //             ? ['label' => 'Регистрация', 'url' => ['/site/register']]
        //             : '',

        //         !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
        //             ? ['label' => 'Личный кабинет', 'url' => ['/account']]
        //             : '',

        //         !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
        //             ? ['label' => 'Мой профиль', 'url' => ['/account/profile/view']]
        //             : '',


        //         !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
        //             ? ['label' => 'Панель управления', 'url' => ['/admin']]
        //             : '',



        //         !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
        //             ? ['label' => 'Почта', 'url' => ['/site/mail']]
        //             : '',


        //         ['label' => 'Главная', 'url' => ['/site/index']],
        //         ['label' => 'О нас', 'url' => ['/site/about']],
        //         ['label' => 'Каталог', 'url' => ['/shop']],



        //         Yii::$app->user->isGuest
        //             ? ['label' => 'Вход', 'url' => ['/site/login']]
        //             : '<li class="nav-item">'
        //             . Html::beginForm(['/site/logout'])
        //             . Html::submitButton(
        //                 'Выход (' . Yii::$app->user->identity->login . ')',
        //                 ['class' => 'nav-link btn btn-link logout']
        //             )
        //             . Html::endForm()
        //             . '</li>'
        //     ]
        // ]); 
        ?>
        <div class="d-flex flex-grow-1 justify-content-center navbar-nav">

            <div>
                <?= Html::a(
                    Html::submitButton('Главная', ['class' => 'btn navigation-style']),
                    ['/site/index'],
                    ['class' => 'text-decoration-none']
                )
                ?>

                <?= Html::a(
                    Html::submitButton('О нас', ['class' => 'btn navigation-style']),
                    ['/site/about'],
                    ['class' => 'text-decoration-none']
                )
                ?>

                <?= Html::a(
                    Html::submitButton('Каталог', ['class' => 'btn navigation-style']),
                    ['/shop'],
                    ['class' => 'text-decoration-none']
                )
                ?>


            </div>
        </div>

        <div>


            <?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
                ? Html::a(
                    Html::submitButton('Панель управления', ['class' => 'btn navigation-style']),
                    ['/admin'],
                    ['class' => 'text-decoration-none']
                )
                : ''
            ?>
            <?= !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? Html::a(
                    Html::submitButton('Личный кабинет', ['class' => 'btn navigation-style']),
                    ['/account'],
                    ['class' => 'text-decoration-none']
                )
                : ''
            ?>

            <?= !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                ? Html::a(
                    Html::submitButton('Мой профиль', ['class' => 'btn navigation-style']),
                    ['/account/profile/view'],
                    ['class' => 'text-decoration-none']
                )
                : ''
            ?>
            <?= Html::a(
                Yii::$app->user->isGuest
                    ? Html::submitButton('Вход', ['class' => 'btn navigation-style'])
                    : Html::submitButton(
                        'Выход (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'btn btn-link logout navigation-style']
                    ),
                Yii::$app->user->isGuest ? ['/site/login'] : ['/site/logout'],
                [
                    'class' => 'text-decoration-none',
                    'data-method' => Yii::$app->user->isGuest ? null : 'post'
                ]
            ) ?>

            <?= Yii::$app->user->isGuest
                ? Html::a(
                    Html::submitButton('Регистрация', ['class' => 'btn navigation-style']),
                    ['/site/register'],
                    ['class' => 'text-decoration-none']
                )
                : ''
            ?>
        </div>
        <?php

        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
            <div class="position-relative">
                <?= Html::a(
                    Html::img('/img/backet.png', ['alt' => 'Корзина']),
                    ['/shop/cart'],
                    ['class' => 'text-decoration-none']
                ) ?>
                <div id="cart-item-count" class="text-white"></div>
            </div>
        <?php $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]);
        endif;
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-dark">

    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>