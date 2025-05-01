<div class="card" style="width: 18rem;">    
    
  <img src="<?= !empty($model->photo) 
        ? '/img/' . $model->photo
        : '/img/no_photo.jpg'
  ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <p class="card-text"><?= $model->title ?></p>
  </div>
</div>