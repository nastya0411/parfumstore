<?php

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

// Подключаем CSS
$this->registerCssFile('@web/css/register.css');
?>

<div class="register-wrapper">
    <h3><?= Html::encode($this->title) ?></h3>
    <p>Заполните форму для регистрации:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-form-label text-start'],
            'template' => "<div class=\"row mb-3\">\n<div class=\"col-sm-4\">{label}</div>\n<div class=\"col-sm-8\">{input}\n{error}</div></div>",
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'full_name')->textInput() ?>
    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7(999)-999-99-99',
    ]) ?>
    <?= $form->field($model, 'email')->input('email') ?>

    <div class="text-center mt-3">
        <?= Html::submitButton('Зарегистрироваться', [
            'class' => 'btn btn-orange w-auto',
            'name' => 'register-button'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>