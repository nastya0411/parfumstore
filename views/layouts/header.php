<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;

?>    
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