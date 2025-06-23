<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

$this->title = 'Мой профиль';

$this->registerCss(".avatar-delete:hover {color: #ab572d}");
$this->registerCssFile('@web/css/avatar.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);

?>

<div class="profile-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="d-flex gap-3 mt-5">
        <div class="card w-25 d-flex flex-column gap-3">
            <div class="card-body d-flex justify-content-center flex-fill">
                <?php Pjax::begin([
                    "id" => "avatar-pjax",
                    "enablePushState" => false,
                    "timeout" => 5000,
                ])
                ?>
                <?php
                $imageAvatar = "/img/" . ($model->avatar
                    ? $model->avatar
                    : Yii::$app->params["avatarDefault"]);

                $this->registerCss(".image-avatar {min-width: 200px; min-height: 200px; max-width: 200px; max-height: 
                200px; border-radius: 50%; background-image: url('$imageAvatar'); background-repeat: no-repeat;
              background-position: center center;background-size: cover; display: block;}");
                ?>
                <div class="image-avatar"></div>

                <?php Pjax::end() ?>
            </div>
            <div class="d-flex justify-content-center pb-3 gap-3">
                <?= Html::a("Изменить", ["avatar-change"], ["class" => "btn btn-orange-style btn-avatar"]) ?>
                <?= Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:
                inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" 
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" 
                d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>', ["avatar-delete", "id" => $model->id], ["class" => "btn btn-orange-style avatar-delete "]) ?>
            </div>
        </div>
        <div class="flex-fill ">
            <div class="d-flex card gap-3 flex-row pb-5 text-white">
                <div class="card-body flex-fill d-flex flex-column gap-3 mt-5">
                    <h5>ФИО: <?= Html::encode($model->full_name) ?></h5>
                    <h5>Логин: <?= Html::encode($model->login) ?></h5>
                    <h5>Телефон: <?= Html::encode($model->phone) ?></h5>
                    <h5>Адрес: <?= $model->address ? $model->address : "не задан" ?></h5>
                    <h5>Адрес электронной почты: <?= Html::encode($model->email) ?></h5>
                </div>
                <div class="d-flex p-3">
                    <?= Html::a('Редактировать', ['update'], ['class' => 'btn btn-orange-style']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    "id" => "avatar-modal",
    'title' => 'Загрузка изображения пользователя',
    'options' => [
        'class' => 'custom-dark-modal',
    ],
    'headerOptions' => [
        'class' => 'custom-modal-header',
        'style' => 'border-bottom: none;' 
    ],
    'bodyOptions' => [
        'class' => 'custom-modal-body'
    ],
    'footerOptions' => [
        'class' => 'custom-modal-footer',
        'style' => 'border-top: none;' 
    ],
    'size' => 'modal-md',
    'clientOptions' => [
        'backdrop' => true,
        'keyboard' => true
    ]
]);

echo $this->render('avatar-form', ["model" => $modelAvatar]);

Modal::end();

$this->registerJsFile("/js/avatar.js", ["depends" => JqueryAsset::class]);
