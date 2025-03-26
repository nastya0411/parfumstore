<?php
 
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 
 /** @var yii\web\View $this */
 /** @var app\models\Application $model */
 /** @var yii\widgets\ActiveForm $form */
 ?>
 
 <div class="application-form">
 
     <?php $form = ActiveForm::begin(); ?>
 
     <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
 
     <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
 
     <?= $form->field($model, 'created_at')->textInput() ?>
 
     <?= $form->field($model, 'date')->textInput() ?>
 
     <?= $form->field($model, 'time')->textInput() ?>
 
     <?= $form->field($model, 'other_reason')->textInput(['maxlength' => true]) ?>
 
     <?= $form->field($model, 'service_id')->textInput() ?>
 
     <?= $form->field($model, 'pay_type_id')->textInput() ?>
 
     <?= $form->field($model, 'status_id')->textInput() ?>
 
     <?= $form->field($model, 'user_id')->textInput() ?>
 
     <div class="form-group">
         <?= Html::submitButton('Создать заказ', ['class' => 'btn btn-outline-success']) ?>
     </div>
 
     <?php ActiveForm::end(); ?>
 
 </div>