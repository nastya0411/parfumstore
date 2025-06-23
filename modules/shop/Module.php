<?php

namespace app\modules\shop;

use Yii;
use yii\filters\AccessControl;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\shop\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],                        
                        'controllers' => ['shop/catalog', 'shop/category']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],                        
                        "actions" => ["qr-payment-end"],
                        'controllers' => ['shop/order']
                    ],                    
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
                'denyCallback' => fn() => Yii::$app->response->redirect('/'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
