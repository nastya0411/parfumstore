<?php

use app\models\PayType;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput([
        'maxlength' => true,
        'placeholder' => 'г. Санкт-Петербург, ул. Ленина, д. 2, кв. 45',
    ]) ?>
    
    <?= $form->field($model, 'phone')->widget(
        \yii\widgets\MaskedInput::class,
        [
            'mask' => '+7(999)-999-99-99',
            'options' => [
                'placeholder' => '+7(999)-999-99-99',
            ],
        ]
    ) ?>

    <div class="d-flex justify-content-start gap-3">

        <?= $form->field($model, 'date')->textInput(['type' => 'date', 'value' => date('Y-m-d'),]) ?>

        <?= $form->field($model, 'time')->textInput(['type' => 'time', 'value' => date('H:i'),]) ?>

    </div>

    <?= $form->field($model, 'pay_receipt')->checkbox([
        'data-on-filter' => 'place',
        'data-off-filter' => 'online',
        'data-url' => Url::to(['pay-type'])
    ]) ?>

    <?= $form->field($model, 'pay_type_id')->dropDownList(PayType::getPayTypesOnline(), ['prompt' => 'Выберете тип оплаты:']) ?>

    <div class="form-group d-flex justify-content-end">
        <?= Html::submitButton('Создать заказа', ['class' => 'btn btn-orange']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJsFile("/js/order.js", ['depends' => JqueryAsset::class]);
?>