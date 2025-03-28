<?php

namespace app\modules\account\controllers;

use app\models\Order;
use app\models\Status;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()
                ->where(['user_id' => Yii::$app->user->id]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new Order();
        $model->scenario = Order::SCENARIO_ORDER;
        $model->user_id = Yii::$app->user->id;
        $model->status_id = Status::getStatusId('Новый');
        $model->total_price = 0; 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Заказ оформлен!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    // public function actionCreate()
    // {
    //     $model = new Order();
    //     $model->scenario = Order::SCENARIO_ORDER;
    //     $model->user_id = Yii::$app->user->id;
    //     $model->status_id = Status::getStatusId('Новый');
    //     $model->total_price = 0;

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->check) {
    //                 $model->scenario = Order::SCENARIO_OTHER;
    //                 $model->product_category_id_id = null;
    //             } else {
    //                 $model->other = null;
    //             }

    //             if ($this->request->isPjax) {
    //                 // reload pjax container
    //                 $model->validate();
    //                 //render form
    //                 return $this->renderAjax('_form', [
    //                     'model' => $model,
    //                 ]);
    //             }

    //             if ($model->save()) {
    //                 Yii::$app->session->setFlash('success', 'Заказ создан');
    //                 return $this->redirect(['view', 'id' => $model->id]);
    //             } else {
    //                 Yii::debug($model->errors);
    //             }
    //         } else {
    //             Yii::debug($model->errors);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
