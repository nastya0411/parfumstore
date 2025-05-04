<?php

// /modules/admin/controllers/StatisticsController.php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order;
use app\models\Product;
use yii\helpers\Json;

class StatisticsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $ordersByDate = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();
    
        $revenueByDate = Order::find()
            ->select(['DATE(created_at) as date', 'SUM(cost) as total'])
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['status_id' => 2]) 
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();
    
        $startDate = new \DateTime(date('Y-m-d', strtotime('-7 days')));
        $endDate = new \DateTime(date('Y-m-d'));
        $dates = [];
        while ($startDate <= $endDate) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }
    
        $revenueByDateComplete = array_fill_keys($dates, 0);
    
        foreach ($revenueByDate as $item) {
            if (isset($revenueByDateComplete[$item['date']])) {
                $revenueByDateComplete[$item['date']] = $item['total'];
            }
        }
    
        $formattedDates = [];
        foreach ($dates as $date) {
            $dateTime = new \DateTime($date);
            $formattedDates[] = $dateTime->format('j F'); 
        }
    
        $revenueByDateFormatted = array_map(function ($date, $value) {
            return ['date' => $date, 'total' => $value];
        }, $formattedDates, $revenueByDateComplete);
    
        $topProducts = Product::getDb()->createCommand("
            SELECT p.id, p.title, COUNT(oi.product_id) AS orders_count
            FROM {{%order_item}} oi
            JOIN {{%product}} p ON oi.product_id = p.id
            GROUP BY oi.product_id
            ORDER BY orders_count DESC
            LIMIT 5
        ")->queryAll();
    
        $timeDistribution = Order::getDb()->createCommand("
            SELECT DATE_FORMAT(created_at, '%H') AS hour, COUNT(*) AS count
            FROM {{%order}}
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY hour
            ORDER BY hour
        ")->queryAll();
    
        return compact('ordersByDate', 'revenueByDateFormatted', 'topProducts', 'timeDistribution');
    }
}