<?php

namespace app\modules\admin\controllers;

use app\models\Order;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Order();
        $model->scenario = Order::SCENARIO_DEFAULT; 

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->isNewRecord) {
                    $model->status_id = Status::getStatusId('Новый');
                }
                
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Заказ успешно создан');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Order::SCENARIO_DEFAULT;

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заказ успешно обновлен');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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