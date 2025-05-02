<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->registerCssFile('@web/css/shop/payment.css');
?>

<div class="payment-page">
    <div class="payment-card">
        <div class="payment-header">
            <h2 class="payment-title"><?= 'Оплата заказа № ' . $model->id . ' от ' .
                                            Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s') ?></h2>
        </div>
        <div class="payment-body">

            <div class="payment-details">
                <h4 class="payment-details-title">Детали платежа</h4>
                <div class="payment-details-row">
                    <div class="payment-details-col">
                        <p><strong>Сумма к оплате:</strong> <?= Html::encode($model->cost) ?> ₽</p>
                    </div>
                    <div class="payment-details-col">
                    <p><strong>Статус:</strong> <?= Html::encode($model->status->title) ?></p>
                    </div>
                </div>
            </div>

            <div class="payment-form-container">
                <?php $form = ActiveForm::begin([
                    'action' => ['payment-success', 'id' => $model->id],
                    'options' => ['class' => 'payment-form'],
                    'enableClientValidation' => true,
                    'validateOnBlur' => true,
                    'validateOnChange' => true,
                    'fieldConfig' => [
                        'options' => ['class' => 'mb-3'],
                        'inputOptions' => ['class' => 'form-control'],
                        'labelOptions' => ['class' => 'form-label'],
                        'errorOptions' => ['class' => 'invalid-feedback'],
                        'template' => "{label}\n{input}\n{error}",
                    ],
                ]); ?>

                <div class="card-preview mb-4">
                    <div class="card-logo">
                        <img src="https://img.icons8.com/color/48/000000/visa.png" id="card-type-img" class="card-logo-img">
                    </div>
                    <div class="card-number-preview">
                        <span id="card-preview-number">•••• •••• •••• ••••</span>
                    </div>
                    <div class="card-footer-preview">
                        <div class="card-holder-preview">
                            <small class="card-label"><?= $model->getAttributeLabel('cardHolder') ?></small>
                            <div id="card-preview-holder">IVAN IVANOV</div>
                        </div>
                        <div class="card-expiry-preview">
                            <small class="card-label"><?= $model->getAttributeLabel('expiry') ?></small>
                            <div id="card-preview-expiry">••/••</div>
                        </div>
                    </div>
                </div>

                <?= $form->field($model, 'cardNumber', [
                    'inputOptions' => [
                        'id' => 'card-number',
                        'class' => 'form-control' . ($model->hasErrors('cardNumber') ? ' is-invalid' : ''),
                        'placeholder' => '1234 5678 9012 3456',
                        'maxlength' => 19
                    ]
                ])->label($model->getAttributeLabel('cardNumber')) ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'expiry', [
                            'inputOptions' => [
                                'id' => 'card-expiry',
                                'class' => 'form-control' . ($model->hasErrors('expiry') ? ' is-invalid' : ''),
                                'placeholder' => 'MM/YY',
                                'maxlength' => 5
                            ]
                        ])->label($model->getAttributeLabel('expiry')) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'cvv', [
                            'inputOptions' => [
                                'id' => 'card-cvv',
                                'class' => 'form-control' . ($model->hasErrors('cvv') ? ' is-invalid' : ''),
                                'placeholder' => 'CVV',
                                'maxlength' => 3
                            ]
                        ])->label($model->getAttributeLabel('cvv')) ?>
                    </div>
                </div>

                <?= $form->field($model, 'cardHolder', [
                    'inputOptions' => [
                        'id' => 'card-holder',
                        'class' => 'form-control' . ($model->hasErrors('cardHolder') ? ' is-invalid' : ''),
                        'placeholder' => 'IVAN IVANOV'
                    ]
                ])->label($model->getAttributeLabel('cardHolder')) ?>

                <div class="payment-submit-container mt-4">
                    <?= Html::submitButton('Оплатить ' . $model->cost . ' ₽', [
                        'class' => 'btn btn-primary w-100',
                        'id' => 'submit-payment'
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.payment-form');
        const cardNumberInput = document.getElementById('card-number');
        const cardExpiryInput = document.getElementById('card-expiry');
        const cardHolderInput = document.getElementById('card-holder');
        const cardCvvInput = document.getElementById('card-cvv');

        const cardPreviewNumber = document.getElementById('card-preview-number');
        const cardPreviewExpiry = document.getElementById('card-preview-expiry');
        const cardPreviewHolder = document.getElementById('card-preview-holder');
        const cardTypeImg = document.getElementById('card-type-img');
        const submitBtn = document.getElementById('submit-payment');

        function isFormValid() {
            const inputs = form.querySelectorAll('.form-control');
            let isValid = true;

            inputs.forEach(input => {
                if (input.classList.contains('is-invalid') ||
                    (input.required && !input.value.trim())) {
                    isValid = false;
                }
            });

            return isValid;
        }

        cardNumberInput.addEventListener('input', function() {
            let value = this.value.replace(/\s/g, '');
            if (value.length > 0) {
                let formatted = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formatted += ' ';
                    formatted += value[i];
                }
                this.value = formatted;

                cardPreviewNumber.textContent = formatted + ' •••• •••• ••••'.substring(formatted.length);
                if (/^4/.test(value)) {
                    cardTypeImg.src = 'https://img.icons8.com/color/48/000000/visa.png';
                } else if (/^5[1-5]/.test(value)) {
                    cardTypeImg.src = 'https://img.icons8.com/color/48/000000/mastercard.png';
                } else if (/^3[47]/.test(value)) {
                    cardTypeImg.src = 'https://img.icons8.com/color/48/000000/american-express.png';
                } else {
                    cardTypeImg.src = 'https://img.icons8.com/color/48/000000/bank-card-back-side.png';
                }
            } else {
                cardPreviewNumber.textContent = '•••• •••• •••• ••••';
                cardTypeImg.src = 'https://img.icons8.com/color/48/000000/bank-card-back-side.png';
            }
        });

        cardExpiryInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                this.value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            cardPreviewExpiry.textContent = this.value || '••/••';
        });

        cardHolderInput.addEventListener('input', function() {
            cardPreviewHolder.textContent = this.value.toUpperCase() || 'IVAN IVANOV';
        });

        form.addEventListener('input', function(e) {
            if (e.target.classList.contains('form-control')) {
                if (e.target.value.trim() !== '' && !e.target.classList.contains('is-invalid')) {
                    e.target.classList.add('is-valid');
                } else {
                    e.target.classList.remove('is-valid');
                }
            }
        });

        form.addEventListener('submit', function(e) {
            if (!isFormValid()) {
                e.preventDefault();

                const inputs = form.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    if (input.required && !input.value.trim()) {
                        input.classList.add('is-invalid');
                        const errorElement = input.nextElementSibling;
                        if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                            errorElement.textContent = 'Это поле обязательно для заполнения';
                        }
                    }
                });

                return false;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Обработка платежа...';

            setTimeout(function() {
                submitBtn.innerHTML = 'Оплата успешно проведена!';
            }, 1500);
        });
    });
</script>