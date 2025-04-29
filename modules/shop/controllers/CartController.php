<?php

namespace app\modules\shop\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use app\modules\shop\models\CartSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::className(),
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //         ]
    //     );
    // }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
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
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
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
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionClear($id)
    {
        if ($model = $this->findModel($id)) {
            $model->delete();
            return $this->asJson(true);
        }
        return $this->asJson(false);
    }


    public function actionCount()
    {
        if ($model = Cart::findOne(['user_id' => Yii::$app->user->id])) {
            return $this->asJson([
                'status' => true,
                'value' => (int)CartItem::find()
                    ->where(['cart_id' => $model->id])
                    ->sum('amount')
            ]);
        }
        return $this->asJson([
            'status' => true,
            'value' => 0
        ]);
    }

    public function actionAdd($id)
    {
        $model = Cart::findOne(['user_id' => Yii::$app->user->id]);
        $product = Product::findOne($id);

        if ($product && $product->count) {
            if (!$model) {
                $model = new Cart();
                $model->user_id = Yii::$app->user->id;
                $model->save();
            }

            $cartItem = CartItem::findOne(['cart_id' => $model->id, 'product_id' => $id]);
            if (!$cartItem) {
                $cartItem = new CartItem();
                $cartItem->cart_id = $model->id;
                $cartItem->product_id = $product->id;
            }

            if ($product->count < $cartItem->amount + 1) {
                return $this->asJson(false);
            }
            $cartItem->amount++;
            $cartItem->cost += $product->price;
            $cartItem->save();

            $model->amount++;
            $model->cost += $product->price;
            $model->save();
            return $this->asJson(true);
        }
        return $this->asJson(false);
    }

    public function actionItemRemove($id)
    {
        if ($model = CartItem::findOne($id)) {
            $model->delete();
            return $this->asJson(true);
        } else {
            return $this->asJson(false);
        }
    }


    public function actionItemAdd($id)
    {
        return $this->actionAdd($id);
    }

    public function actionItemDel($id)
    {
        $model = Cart::findOne(['user_id' => Yii::$app->user->id]);
        $product = Product::findOne($id);

        if ($model && $product) {
            if (!$model) {
                $model = new Cart();
                $model->user_id = Yii::$app->user->id;
                $model->save();
            }

            $cartItem = CartItem::findOne(['cart_id' => $model->id, 'product_id' => $id]);

            $cartItem->amount--;
            $cartItem->cost -= $product->price;
            $cartItem->save();

            if ($cartItem->amount == 0) {
                $cartItem->delete();
            }

            $model->amount--;
            $model->cost -= $product->price;
            $model->save();
            return $this->asJson(true);
        }
        return $this->asJson(false);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
