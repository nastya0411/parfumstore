<?php

namespace app\modules\account\controllers;

use app\models\User;
use app\modules\account\models\UserAvatarForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $model->newPassword = "";

        return $this->render('update', ['model' => $model]);
    }

    public function actionAvatarDelete($id)
    {
        if ($model = $this->findModel(Yii::$app->user->id)) {
            $model->avatar = null;
            return $this->asJson($model->save());
        }

        return $this->asJson(false);
    }



    public function actionView()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $modelAvatar = new UserAvatarForm();
        if (Yii::$app->request->isPost) {
            $modelAvatar->avatarImage = UploadedFile::getInstance($modelAvatar, 'avatarImage');
            if ($imageFile = $modelAvatar->upload($model->avatar)) {
                $model->avatar = $imageFile;
                $model->save();
            }
        }
        return $this->render('view', ['model' => $model, "modelAvatar" => $modelAvatar]);
    }





    private function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Пользователь не найден.');
    }
}
