<?php

use app\models\Product;
use app\models\StarsUser;
use kartik\rating\StarRating;
use yii\widgets\Pjax;
?>

<?php Pjax::begin([
    'id' => "stars-block-pjax",
    "enablePushState" => false,
    "timeout" => 5000,
]) ?>

<?php
        $distribution = StarsUser::find()
            ->select(['ROUND(stars) as rounded_stars', 'COUNT(*) as count'])
            ->where(['product_id' => $model->id])
            ->groupBy('rounded_stars')
            ->asArray()
            ->all();

        $distributionMap = [];
        foreach ($distribution as $item) {
            $distributionMap[(int)$item['rounded_stars']] = $item['count'];
        }

        $totalRatings = array_sum($distributionMap);
        ?>
<div>
    Общий рейтинг товара: <?= Yii::$app->formatter->asDecimal(Product::getRatingProduct($model->id), 1) ?>
</div>
        <div class="rating-distribution mt-2">
            <h6 class="mb-2">Распределение оценок:</h6>
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <div class="d-flex align-self-stretch">
                    <div style="width: 70px;">
                        <span class="text-muted small"><?= $i ?> звезд<?= $i > 1 && $i < 5 ? 'ы' : '' ?></span>
                    </div>
                    <div >
                        <?= StarRating::widget([
                            'name' => 'rating-dist-' . $i,
                            'value' => $i,
                            'pluginOptions' => [
                                'size' => 'xs',
                                'readonly' => true,
                                'showClear' => false,
                                'showCaption' => false,
                                'min' => 0,
                                'max' => 5,
                                'step' => 1,
                                'displayOnly' => true
                            ]
                        ]) ?>
                    </div>
                    <div >
                        <span class="badge bg-light text-dark small">
                            <?= $distributionMap[$i] ?? 0 ?> чел.
                        </span>
                    </div>
                </div>
            <?php endfor; ?>
            <div class="text-ыефке small text-muted mb-2">
                Всего оценок: <?= $totalRatings ?>
            </div>
        </div>
    <?php Pjax::end() ?>  