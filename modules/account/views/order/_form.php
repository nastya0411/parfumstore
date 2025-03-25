<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="order-form">
    <?php $form = ActiveForm::begin(); ?>
    <? # $form->field($model, 'product_category_id')->textInput() 
    ?>
    <div class="d-flex gap-4">
        <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>
        <?= $form->field($model, 'time')->textInput(['type' => 'time']) ?>
    </div>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7(999)-999-99-99',
    ]) ?>
    <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>
    <? # $form->field($model, 'other_reason')->textInput(['maxlength' => true]) 
    ?>
    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-outline-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>