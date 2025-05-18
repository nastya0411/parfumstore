<?php

use app\models\Product;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php Pjax::begin([
        'id' => 'catalog-pjax',

        // 'enablePushState' => false,
        // 'timeout' => 5000,
    ]); ?>

    <dip>
        <?php $form = ActiveForm::begin([
            // 'id' => 'catalog-search-form',
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <?= $form->field($searchModel, 'product')->textInput() ?>

        <?= $form->field($searchModel, 'category_id')->dropDownList($categories, ['prompt' => "Выберете категорию"]) ?>

        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item my-3 col-md-3 col-sm-6 mb-4'],
    'layout' => '<div class="row">{items}</div>{pager}',
    'itemView' => 'item',
    'pager' => [
        'class' => LinkPager::class
    ],
]) ?>

<?php Pjax::end(); ?>

</div>