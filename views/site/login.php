<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;

// Подключаем CSS
$this->registerCssFile('@web/css/login.css');
?>

<div class="login-wrapper">
    <h3><?= Html::encode($this->title) ?></h3>
    <p>Введите ваш логин и пароль:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal', // Горизонтальная форма
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-form-label text-start'],
            'template' => "<div class=\"row mb-3\">\n<div class=\"col-sm-4\">{label}</div>\n<div class=\"col-sm-8\">{input}\n{error}</div></div>",
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"row mb-3\">\n<div class=\"col-sm-4 offset-sm-0\"></div>\n<div class=\"col-sm-8\">{input} {label}</div>\n</div>",
    ]) ?>

    <!-- Обёртка для кнопки -->
    <div class="text-center mt-3">
        <?= Html::submitButton('Войти', [
            'class' => 'btn btn-orange w-auto', // w-auto — ширина по содержимому
            'name' => 'login-button'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>