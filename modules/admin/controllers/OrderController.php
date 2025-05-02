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

    // public function actionCreate()
    // {
    //     $model = new Order();
    //     $model->scenario = Order::SCENARIO_DEFAULT; 

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->isNewRecord) {
    //                 $model->status_id = Status::getStatusId('Создан');
    //             }
                
    //             if ($model->save()) {
    //                 Yii::$app->session->setFlash('success', 'Заказ успешно создан');
    //                 return $this->redirect(['view', 'id' => $model->id]);
    //             }
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Order::SCENARIO_CANCEL;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->status_id = Status::getStatusId('Отменен');
            if ($model->save())
            Yii::$app->session->setFlash('warning','Заказ отменена');
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
            $model->status_id = Status::getStatusId('В работе');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заказ принят в работу!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    public function actionApply($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->status_id = Status::getStatusId('Доставлен');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заказ успешно доставлен!');
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