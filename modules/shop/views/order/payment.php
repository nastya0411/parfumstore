<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->registerCssFile('@web/css/payment.css');
?>

<div class="payment-page">
    <div class="payment-card">
        <div class="payment-header bg-orange ">
            <h2 class="payment-title">
                <?= 'Оплата заказа № ' . $model->id . ' от ' .
                    Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i.s') ?>
            </h2>
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

                <div class="card-preview mb-4 bg-black" style="max-width: 350px; margin: 0 auto;">
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
                        <?= $form->field($model, 'cvv')->passwordInput([
                            'id' => 'card-cvv',
                            'class' => 'form-control' . ($model->hasErrors('cvv') ? ' is-invalid' : ''),
                            'placeholder' => 'CVV',
                            'maxlength' => 3
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
                        'class' => 'btn btn-orange-style w-100',
                        'id' => 'submit-payment'
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile("/js/payment.js", ["position" => $this::POS_END])
?>