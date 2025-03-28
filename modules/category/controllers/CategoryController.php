<?php

namespace app\modules\category\controllers;

use app\models\Category;
use app\models\CategoryProp;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
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
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CategoryProp::find()->where(['category_id' => $id]),

        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' =>$dataProvider,

        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
        $props = [new CategoryProp()];


        if ($this->request->isPost) {

            if ($id = $this->request->post('Category')['id']) {
                $model = Category::findOne($id);
            }


            if ($model->load($this->request->post()) && $model->save()) {
                $props = [];

                foreach ($this->request->post('CategoryProp') as $category) {
                    $prop = $category['id']
                        ? CategoryProp::findOne($category['id'])
                        : new CategoryProp();
                    $prop->load($category, '');
                    $prop->category_id = $model->id;
                    $props[] = $prop;
                }

                if (Model::validateMultiple($props)) {
                    // сначала удалить из бд
                    CategoryProp::deleteAll([
                        'not in',
                        'id',
                        array_map(fn($val) => $val->id, $props)

                    ]);

                    foreach ($props as $prop) {
                        if (!$prop->save(false)) {
                            // VarDumper::dump($prop->errors, 10, true);
                            // die;
                        }
                    }
                } else {
                    VarDumper::dump(array_map(fn($val) => $val->errors, $props), 10, true);
                    die;
                }
            }


            // if ($model->load($this->request->post()) && $model->save()) {
            //     return $this->redirect(['view', 'id' => $model->id]);
            // }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'props' => $props,

        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!($props = CategoryProp::find()->where(['category_id' => $id])->all())) {
            $props = [new CategoryProp()];
        }

        if ($model->load($this->request->post()) && $model->save()) {
            $props = [];

            foreach ($this->request->post('CategoryProp') as $category) {
                $prop = $category['id']
                    ? CategoryProp::findOne($category['id'])
                    : new CategoryProp();
                $prop->load($category, '');
                $prop->category_id = $model->id;
                $props[] = $prop;
            }

            if (Model::validateMultiple($props)) {
                // сначала удалить из бд
                CategoryProp::deleteAll([
                    'not in',
                    'id',
                    array_map(fn($val) => $val->id, $props)

                ]);

                foreach ($props as $prop) {
                    if (!$prop->save(false)) {
                        // VarDumper::dump($prop->errors, 10, true);
                        // die;
                    }
                }
            } else {
                VarDumper::dump(array_map(fn($val) => $val->errors, $props), 10, true);
                die;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'props' => $props,

        ]);
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
