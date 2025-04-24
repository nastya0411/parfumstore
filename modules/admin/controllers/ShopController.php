<?php

namespace app\modules\admin\controllers;

class ShopController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
