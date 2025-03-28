<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Notes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="notes-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-notes'
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ->label('Название нот')?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <p>
        Список нот
    </p>

    <div id="block-props" class='border p-3 mb-3'>
        <?php foreach ($props as $key => $prop): ?>
            <div class='border p-3 my-3 notes-props col-6' data-index="<?= $key ?>">
                <div class="d-flex justify-content-end ">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-outline-danger btn-remove">-</button>
                        <button type="button" class="btn btn-outline-success btn-add">+</button>
                    </div>

                </div>
                <div class="d-flex gap-3">
                    <?= $form->field($prop, "[$key]title")->textInput(['maxlength' => true])->label('Название ноты') ?>
                    <?= $form->field($prop, "[$key]value")->textInput()->label('Значение') ?>
                    <?= $form->field($prop, "[$key]id")->hiddenInput()->label(false) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $this->registerJsFile('/js/props.js', ['depends' => JqueryAsset::class]);
?>