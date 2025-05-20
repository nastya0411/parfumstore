<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\models\PayType;
use app\models\Status;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrderController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('@app/modules/shop/views/order/view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Order::SCENARIO_CANCEL;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->status_id = Status::getStatusId('Отменен');
            if ($model->save())
                Yii::$app->session->setFlash('warning', 'Заказ отменен');
            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('cancel', [
            'model' => $model,
        ]);
        return $this->redirect('@app/modules/shop/views/order/view');
    }


    public function actionWork($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId('В сборке');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заказ принят в сборку!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function actionApply($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->pay_receipt) {
                $model->status_id = Status::getStatusId('Заказ выдан');
                Yii::$app->session->setFlash('success', 'Заказ успешно выдан!');
            } else {
                $model->status_id = Status::getStatusId('Доставлен');
                Yii::$app->session->setFlash('success', 'Заказ успешно доставлен!');
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function actionPaid($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId('Оплачен оффлайн');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заказ успешно оплачен!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Заказ успешно удален');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Заказ не найден');
    }
}
