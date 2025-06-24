<?php

use app\models\Sex;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;



/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions([
            'elfinder',
            [
                'preset' => 'full', 
                'inline' => false,
            ],
        ])
    ]) 
    ?>

    <?= $form->field($model, 'sex_id')->dropDownList(Sex::getSexes(), ['prompt' => 'Выберете для кого предназначен товар']) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= Accordion::widget([
        'items' => [
            [
                'label' => 'Категории',
                'content' => $form->field($model, 'categories')->checkboxList($categories),
                // 'headerOptions' => ['tag' => 'h3'],
                'options' => ['tag' => 'div'],
            ],
            [
                'label' => 'Верхние ноты',
                // 'headerOptions' => ['tag' => 'h3'],
                'content' => $form->field($model, 'noteLevels[1]')->checkboxList($allNotes)->label('Верхние ноты'),
                'options' => ['tag' => 'div'],
            ],
            [
                'label' => 'Средние ноты',
                // 'headerOptions' => ['tag' => 'h3'],
                'content' => $form->field($model, 'noteLevels[2]')->checkboxList($allNotes)->label('Средние ноты'),
                'options' => ['tag' => 'div'],
            ],
            [
                'label' => 'Базовые ноты',
                // 'headerOptions' => ['tag' => 'h3'],
                'content' => $form->field($model, 'noteLevels[3]')->checkboxList($allNotes)->label('Базовые ноты'),
                'options' => ['tag' => 'div'],
            ],
        ],
    ]); ?>



    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-orange-style']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>