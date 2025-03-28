<?php

namespace app\modules\notes\controllers;

use app\models\Notes;
use app\models\NotesProp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * NotesController implements the CRUD actions for Notes model.
 */
class NotesController extends Controller
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
     * Lists all Notes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Notes::find(),
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
     * Displays a single Notes model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NotesProp::find()->where(['notes_id' => $id]),

        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' =>$dataProvider,

        ]);
    }

    /**
     * Creates a new Notes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Notes();
        $props = [new NotesProp()];

        if ($this->request->isPost) {

            if ($id = $this->request->post('Notes')['id']) {
                $model = Notes::findOne($id);
            }

            if ($model->load($this->request->post()) && $model->save()) {
                $props = [];
                
                
                foreach ($this->request->post('NotesProp') as $note) {
                    $prop = $note['id']
                    ? NotesProp::findOne($note['id'])
                    : new NotesProp();
                    $prop->load($note, '');
                    $prop->notes_id = $model->id;                    
                    $props[] = $prop;
                }
                
                

                if (Model::validateMultiple($props)) {
                    // сначала удалить из бд
                    NotesProp::deleteAll([
                        'not in',
                        'id',
                        array_map(fn($val) => $val->id, $props)

                    ]);

                    foreach ($props as $prop) {
                        if (!$prop->save(false)) {
                            VarDumper::dump($prop->errors, 10, true);
                            die;

                        }
                    }
                } else {
                    VarDumper::dump(array_map(fn($val) => $val->errors, $props), 10, true);
                    die;
                }
            }

            // VarDumper::dump($this->request->post(), 10, true); 

            // {
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
     * Updates an existing Notes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!($props = NotesProp::find()->where(['notes_id' => $id])->all())) {
            $props = [new NotesProp()];
        }

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                $props = [];

                foreach ($this->request->post('NotesProp') as $notes) {
                    $prop = $notes['id']
                        ? NotesProp::findOne($notes['id'])
                        : new NotesProp();
                    $prop->load($notes, '');
                    $prop->notes_id = $model->id;
                    $props[] = $prop;
                }

                if (Model::validateMultiple($props)) {
                    // сначала удалить из бд
                    NotesProp::deleteAll([
                        'not in',
                        'id',
                        array_map(fn($val) => $val->id, $props)

                    ]);

                    foreach ($props as $prop) {
                        $prop->save(false);
                    }
                } else {
                    VarDumper::dump(array_map(fn($val) => $val->errors, $props), 10, true);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'props' => $props,

            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'props' => $props,

        ]);
    }

    /**
     * Deletes an existing Notes model.
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
     * Finds the Notes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Notes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notes::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
