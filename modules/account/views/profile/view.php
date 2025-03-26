<?php

use yii\helpers\Html;

$this->title = 'Мой профиль';
?>

<div class="profile-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <h5>ФИО: <?= Html::encode($model->full_name) ?></h5>
            <h5>Логин: <?= Html::encode($model->login) ?></h5>
            <h5>Телефон: <?= Html::encode($model->phone) ?></h5>
            <h5>Адрес электронной почты: <?= Html::encode($model->email) ?></h5>
        </div>
    </div>
</div>