<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>

<div class="payment-mock">
    <h2>Оплата заказа #<?= $model->id ?></h2>
    <p class="amount">Сумма: <strong><?= $model->cost ?> ₽</strong></p>

    <?php $form = ActiveForm::begin([
    'action' => ['/order/payment-success', 'id' => $model->id],
]); ?>

    <div class="card-wrapper">
        <div class="card-preview">
            <div class="card-number">•••• •••• •••• ••••</div>
            <div class="card-expiry">MM/YY</div>
            <div class="card-cvv">CVV</div>
        </div>
    </div>

    <?= $form->field($model, 'cardNumber')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '9999 9999 9999 9999',
        'options' => [
            'placeholder' => '1234 5678 9012 3456',
            'class' => 'form-control card-input'
        ]
    ])->label('Номер карты') ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'expiry')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '99/99',
                'options' => [
                    'placeholder' => 'MM/YY',
                    'class' => 'form-control'
                ]
            ])->label('Срок действия') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cvv')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '999',
                'options' => [
                    'placeholder' => '123',
                    'class' => 'form-control'
                ]
            ])->label('CVV/CVC') ?>
        </div>
    </div>

    <?= $form->field($model, 'cardHolder')->textInput([
        'placeholder' => 'IVAN IVANOV'
    ])->label('Имя владельца') ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('Оплатить', [
            'class' => 'btn btn-success btn-lg w-100',
            'onclick' => 'showFakeProcessing()'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
function showFakeProcessing() {
    setTimeout(() => {
        alert('Платеж успешно проведен!');
    }, 1500);
}
</script>