<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-category'
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название категории') ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <p>
        Список категорий
    </p>

    <div id="block-props" class='border p-3 mb-3'>
        <?php foreach ($props as $key => $prop): ?>
            <div class='border p-3 my-3 category-propscategory col-6' data-index="<?= $key ?>">
                <div class="d-flex justify-content-end ">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-outline-danger btn-remove">-</button>
                        <button type="button" class="btn btn-outline-success btn-add">+</button>
                    </div>

                </div>
                <div class="d-flex gap-3">
                    <?= $form->field($prop, "[$key]title")->textInput(['maxlength' => true]) ->label('Название компанента')?>
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
$this->registerJsFile('/js/propscategory.js', ['depends' => JqueryAsset::class]);
?>