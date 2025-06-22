<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Редактирование профиля';
?>

<div class="profile-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'login') ?>
    <label class="control-label">Пароль</label>
    <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => 'Введите новый пароль'])->label(false) ?>
    <?= $form->field($model, 'full_name') ?>
    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7(999)-999-99-99',
    ]) ?>
    <?= $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>