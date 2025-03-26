<?php

namespace app\modules\account\controllers;

use app\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class ProfileController extends \yii\web\Controller
{
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);
        
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->newPassword)) {
                $model->setPassword($model->newPassword); 
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Данные обновлены!');
                return $this->redirect(['view']);
            }
        }
        
        return $this->render('update', ['model' => $model]);
    }

    public function actionView()
    {
        $model = $this->findModel(Yii::$app->user->id);
        return $this->render('view', ['model' => $model]);
    }
    private function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Пользователь не найден.');
    }

}
