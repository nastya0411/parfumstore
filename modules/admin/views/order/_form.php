<?php
  
  use yii\bootstrap5\Html;
  use yii\bootstrap5\ActiveForm;
  
  /** @var yii\web\View $this */
  /** @var app\models\Application $model */
  /** @var yii\widgets\ActiveForm $form */
  ?>
  
  <div class="application-form">
  
      <?php $form = ActiveForm::begin(); ?>
   
      <?= $form->field($model, 'other_reason')->textInput(['maxlength' => true]) ?>
  

      <div class="form-group">
          <?= Html::submitButton('Отменить заказ', ['class' => 'btn btn-red-style']) ?>
      </div>
  
      <?php ActiveForm::end(); ?>
  
  </div>