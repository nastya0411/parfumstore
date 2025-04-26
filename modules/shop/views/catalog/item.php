<?php
 
 use yii\bootstrap5\Html;
 
 ?>
 <div class="card" style="width: 18rem; height: 33rem;">
   <!-- <img src="/img/<#?= $model->photo ? $model->photo : '1.png' ?>" class="card-img-top" alt="photo"> -->
 
   <div class="card-body">    
     <div class="my-2 mb-3">
       <h4><?= Html::a($model->title, ['view', 'id' => $model->id],  ['class' => 'text-decoration-none']) ?></h4>
     </div>
 
     <div class="my-2">
         <!-- Состав: <#?= $model->note ?> -->
     </div>
     <div class="d-flex justify-content-between">
         <!-- <div class="my-2">
             (<#?= $model->amount ?>)  -->
        <!-- <#?= $model->cost ?> -->

         <div class="my-2">
             (<?= $model->price ?>) 
         </div>    
         <div class="my-2 fs-4 fw-bold">
             <?= $model->count ?>
         </div>
     </div>
     
     <div>
     <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-info w-100']) ?>

     <?= Html::a('В корзину', ['cart/add', 'id' => $model->id], ['class' => 'btn btn-outline-success w-100']) ?>
     </div>
 
   </div>
 </div>