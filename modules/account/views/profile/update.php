<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Редактирование профиля';
?>
<style>
.label-background {
    background-color: #1a1a1a; /* Тёмно-серый цвет */
    padding: 14px;
    border-radius: 8px;
    display: inline-block;
    width: 100%;
    box-sizing: border-box;
}
</style>

<div class="profile-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="label-background">
        <?= $form->field($model, 'login') ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => 'Введите новый пароль'])->label('Пароль') ?>
        <?= $form->field($model, 'full_name') ?>
        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '+7(999)-999-99-99',
        ]) ?>
        <?= $form->field($model, 'address')->textInput(["value" => "г. Санкт-Петербург, ул. Ленина, д. 2, кв. 45"]) ?>
        <?= $form->field($model, 'email') ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-orange-style']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>