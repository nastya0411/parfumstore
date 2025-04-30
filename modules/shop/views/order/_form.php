<?php

use app\models\PayType;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7(999)-999-99-99',]) ?>

    <div class="d-flex justify-content-start gap-3">

        <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'time')->textInput(['type' => 'time']) ?>
        
    </div>

    <?= $form->field($model, 'pay_receipt')->checkbox() ?>

    <?= $form->field($model, 'pay_type_id')->dropDownList(PayType::getPayTypes(), ['prompt' => 'Выберете тип оплаты:']) ?>

    <div class="form-group d-flex justify-content-end">
        <?= Html::submitButton('Создать заказа', ['class' => 'btn btn-outline-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>