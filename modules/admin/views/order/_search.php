<?php
 
 use yii\helpers\Html;
 use yii\widgets\ActiveForm;
 
 /** @var yii\web\View $this */
 /** @var app\modules\admin\models\ApplicationSearch $model */
 /** @var yii\widgets\ActiveForm $form */
 ?>
 
 <div class="application-search">
 
     <?php $form = ActiveForm::begin([
         'action' => ['index'],
         'method' => 'get',
         'options' => [
             'data-pjax' => 1
         ],
     ]); ?>
 
     <?= $form->field($model, 'id') ?>
 
     <?= $form->field($model, 'address') ?>
 
     <?= $form->field($model, 'phone') ?>
 
     <?= $form->field($model, 'created_at') ?>
 
     <?= $form->field($model, 'date') ?>
 
     <?php // echo $form->field($model, 'time') ?>
 
     <?php // echo $form->field($model, 'other') ?>
 
     <?php // echo $form->field($model, 'product_category_id') ?>
 
     <?php // echo $form->field($model, 'pay_type_id') ?>
 
     <?php // echo $form->field($model, 'status_id') ?>
 
     <?php // echo $form->field($model, 'user_id') ?>
 
     <div class="form-group">
         <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
         <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
     </div>
 
     <?php ActiveForm::end(); ?>
 
 </div>