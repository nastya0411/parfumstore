<?php

namespace app\modules\shop\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Order;
use app\models\OrderItem;
use app\models\PayType;
use app\models\Status;
use app\modules\shop\models\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

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
        $searchModel = new OrderSearch();
        $params = $this->request->queryParams;
        $params['OrderSearch']['user_id'] = Yii::$app->user->id;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
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


    public function actionPayType(string $type)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($type == 'online') {
                return $this->asJson([
                    "status" => true,
                    "options" => PayType::getPayTypesOnline()
                ]);
            } else {
                return $this->asJson([
                    "status" => true,
                    "options" => PayType::getPayTypesPlace()
                ]);
            }
        }
        return [
            "status" => false
        ];
    }


    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($cart_id)
    {
        $model = new Order();
        $dataProvider = (new OrderSearch())->orderCreate($cart_id);
        $model->user_id = Yii::$app->user->id;
        $model->phone = $model->user->phone;
        // $model->status_id = Status::getStatusId('Новый');
        $model->cost = 0;

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $cart = Cart::findOne($cart_id);
                $isPaymentOnDelivery = (bool)$model->pay_receipt;
                $model->status_id = $isPaymentOnDelivery
                    ? Status::getStatusId('Создан')
                    : Status::getStatusId('Ожидает оплаты');
                // $model->status_id = Status::getStatusId('Новый');
                $model->load($cart->attributes, '');

                // VarDumper::dump($model->attributes, 10, true); die;
                if ($model->save()) {
                    $cartItems = CartItem::find()
                        ->where(['cart_id' => $cart->id])
                        ->all();
                    foreach ($cartItems as $cartItem) {
                        $shopItem = new OrderItem();
                        $shopItem->load($cartItem->attributes, '');
                        $shopItem->order_id = $model->id;
                        $shopItem->save();
                        // VarDumper::dump($cart->attributes, 10, true);    
                    }
                    // $model->status_id = Status::getStatusId('Создан');
                    // $model->save();
                } else {
                    VarDumper::dump($model->errors, 10, true);
                    die;
                }

                $cart->delete();
                if ($isPaymentOnDelivery) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    // dd($model->payType->isQR);
                    return $model->payType->isQR
                        ? $this->redirect(['qr-payment', 'id' => $model->id])
                        : $this->redirect(['payment', 'id' => $model->id]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

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

    public function actionPayment($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'payment';
        return $this->render('payment', ['model' => $model]);
    }

    public function actionPaymentSuccess($id)
    {
        $model = $this->findModel($id);
        $model->status_id = Status::getStatusId('Оплачен онлайн');
        $model->save();

        Yii::$app->session->setFlash('success', 'Платеж успешно проведен!');
        return $this->redirect(['view', 'id' => $model->id]);
    }


    public function actionQrPayment($id)
    {
        $model = $this->findModel($id);
        return $this->render('qr-payment', ['model' => $model]);
    }

    public function actionQrPaymentEnd($id)
    {
        $model = $this->findModel($id);
        if ($model->load($this->request->post())) {
            $model->status_id = Status::getStatusId("Оплачен онлайн");
            $model->save();
        }
        return $this->render('qr-payment-end', ['model' => $model]);
    }

    public function actionQrPaymentHook($id)
    {
        $model = $this->findModel($id);
        return $this->asJson([
            "status" => $model->status_id == Status::getStatusId("Оплачен онлайн")
        ]);

        // return $this->render('qr-payment', ['model' => $model]);
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
