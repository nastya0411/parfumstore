<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;

?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/img/logo.png" alt="Логотип" style="height: 50px;">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-lg navbar-dark bg-black fixed-top',
        ],
        'collapseOptions' => [
            'class' => 'justify-content-between navbar-collapse collapse',
            'id' => 'navbarCollapse'
        ],
    ]);
    ?>

    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="d-flex flex-grow-1 justify-content-center navbar-nav">
            <div class="d-flex align-items-center gap-4">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'navigation-style']) ?>
                <?= Html::a('О нас', ['/site/about'], ['class' => 'navigation-style']) ?>
                <?= Html::a('Каталог', ['/shop'], ['class' => 'navigation-style']) ?>
            </div>
        </div>

        <div class="d-flex align-items-center gap-4 ms-auto">
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
                <?= Html::a('Панель управления', ['/admin'], ['class' => 'navigation-style']) ?>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                <?= Html::a('Личный кабинет', ['/account'], ['class' => 'navigation-style']) ?>
                <?= Html::a('Мой профиль', ['/account/profile/view'], ['class' => 'navigation-style']) ?>
            <?php endif; ?>

            <?= Html::a(
                Yii::$app->user->isGuest ? 'Вход' : 'Выход (' . Yii::$app->user->identity->login . ')',
                Yii::$app->user->isGuest ? ['/site/login'] : ['/site/logout'],
                [
                    'class' => 'navigation-style',
                    'data-method' => Yii::$app->user->isGuest ? null : 'post'
                ]
            ) ?>

            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('Регистрация', ['/site/register'], ['class' => 'navigation-style']) ?>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                <div class="position-relative">
                    <?= Html::a(
                        Html::img('/img/backet.png', ['alt' => 'Корзина']),
                        ['/shop/cart'],
                        ['class' => 'text-decoration-none']
                    ) ?>
                    <div id="cart-item-count" class="text-white"></div>
                </div>
                <?php $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php NavBar::end(); ?>
</header>