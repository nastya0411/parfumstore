<?php

namespace app\modules\shop\controllers;

use app\models\Category;
use app\models\Product;
use app\models\StarsUser;
use app\modules\shop\models\CatalogSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * CatalogController implements the CRUD actions for Product model.
 */
class CatalogController extends Controller
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
    // public function actionStars($id)
    // {
    //     if (Product::findOne(["id" => $id])) {
    //         if (!StarsUser::findOne(['user_id' => Yii::$app->user->id, 'product_id' => $id])) {
    //             $model = new StarsUser();
    //             $model->user_id = Yii::$app->user->id;
    //             $model->product_id = $id;

    //             $model->stars = $this->request->post('stars');
    //             return $this->asJson($model->save());
    //         }
    //         return $this->asJson(false);
    //     }
    // }

    public function actionStars($id)
    {
        if ($product = Product::findOne(["id" => $id])) {
            $userId = Yii::$app->user->id;
            $starsUser = StarsUser::findOne(['user_id' => $userId, 'product_id' => $id]);

            if (!$starsUser) {
                $model = new StarsUser();
                $model->user_id = $userId;
                $model->product_id = $id;
                $model->stars = $this->request->post('stars');
                if ($model->save()) {
                    $avg = StarsUser::find()
                        ->where(['product_id' => $id])
                        ->average('stars');
                    $product->stars = $avg;
                    return $this->asJson($product->save());
                }
            }
            return $this->asJson(false);
        }
        return $this->asJson(false);
    }
    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => Category::getCategories()
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id Номер товара
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     $stars = StarsUser::findOne(['user_id' => Yii::$app->user->id, 'product_id' => $id]);

    //     if ($stars) {
    //         $stars = (float)$stars->stars;
    //     } else {
    //         $stars = 0;
    //     }
    //     $model = $this->findModel($id);
    //     $model->user_stars = $stars;

    //     return $this->render('view', [
    //         'model' => $model,
    //         'stars' => $stars
    //     ]);
    // }

    public function actionView($id)
    {
        $stars = StarsUser::find()
            ->where(['user_id' => Yii::$app->user->id, 'product_id' => $id])
            ->select('stars')
            ->scalar();

        $stars = $stars ? (float)$stars : 0;

        $model = $this->findModel($id);
        $model->user_stars = $stars;

        return $this->render('view', [
            'model' => $model,
            'stars' => $stars
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Номер товара
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
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Номер товара
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Номер товара
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
