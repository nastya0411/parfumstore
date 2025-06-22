<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>

<?php Pjax::begin([
    "id" => "form-avatar-pjax",
    "enablePushState" => false,
    "timeout" => 5000,
    "clientOptions" => [
        "skipOuterContainers" => true, // Важно для форм с файлами
    ]
]) ?>
<?php $form = ActiveForm::begin([
    "id" => "form-avatar",
    'options' => [
        "data-pjax" => true,
    ],
    'fieldConfig' => [
        'labelOptions' => ['class' => 'control-label text-dark'], // Добавляем класс для label
    ],
]) ?>

<?= $form->field($model, 'avatarImage', [
    'template' => "{label}\n{input}\n{hint}\n{error}", // Явно указываем шаблон
])->fileInput([
    'class' => 'form-control-file',
    'accept' => 'image/*' // Ограничение только для изображений
])->label('Изображение', ['class' => 'text-dark']) ?>
<div class="d-flex justify-content-center">

    <?= Html::submitButton("Сохранить", ["class" => "btn btn-orange btn-avatar-save"]) ?>
</div>

<?php ActiveForm::end() ?>
<?php Pjax::end() ?>