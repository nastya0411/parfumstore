<?php
use app\models\Status;
use yii\helpers\Html;
?>
<h2>Изменение статуса заказа #<?= Html::encode($model->id) ?></h2>


<p>Статус заказа #<?= Html::encode($model->id) ?> изменен на "<?= Html::encode($model->status->title) ?>"</p>


<div>Номер заказа: <?= Html::encode($model->id) ?></div>
<div>Дата получения заказа: <?= Yii::$app->formatter->asDate($model->date) ?></div>
<div>Время получения заказа: <?= Yii::$app->formatter->asTime($model->time) ?></div>

<?php if ($model->status_id == Status::getStatusId('Доставлен')): ?>
    <p>Ваш заказ был успешно доставлен.</p>
<?php elseif ($model->status_id == Status::getStatusId('Заказ выдан')): ?>
    <p>Ваш заказ готов к выдаче.</p>
<?php endif; ?>