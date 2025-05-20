<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ProductMainSearch;
use app\models\ProductSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = (new ProductMainSearch())->search();
        return $this->render('index', [
            "dataProvider" => $dataProvider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вы успешно авторизованы!');
            return  Yii::$app->user->identity->isAdmin
                ? $this->redirect('/admin')
                : $this->redirect('/account');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new \app\models\RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->userRegister()) {
                Yii::$app->user->login($user, 3600 * 24 * 30);
                Yii::$app->session->setFlash('success', 'Вы успешно зарегистрированы!');
                return $this->redirect('/account');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionMail()
    {

        Yii::$app->mailer->htmlLayout = '@app/mail/layouts/html';
        
        if (Yii::$app->mailer
            ->compose('mail', [])
            ->setFrom('parfumstore_info@mail.ru')
            ->setTo('parfumstore_info@mail.ru')
            ->setSubject('test')
            ->send()
        ) {
            Yii::$app->session->setFlash('success', 'send mail');
        } else {
            Yii::$app->session->setFlash('error', 'error send mail');
        };
        return $this->redirect('index');
    }
}
