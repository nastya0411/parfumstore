<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */
/** @var ActiveForm $form */
?>
<div class="site-register">
<h3>Регистрация</h3>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login')?>
        <?= $form->field($model, 'password')->passwordInput()?>
        <?= $form->field($model, 'full_name') ?>
        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '+7(999)-999-99-99',]) ?>
        <?= $form->field($model, 'email') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-orange']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
