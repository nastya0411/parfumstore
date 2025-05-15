<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order;
use app\models\Status;

class StatisticsController extends Controller
{
    public function actionIndex()
    {
        $startDate = new \DateTime(date('Y-m-d', strtotime('-7 days')));
        $endDate = new \DateTime(date('Y-m-d'));
        $dates = [];

        while ($startDate <= $endDate) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }

        $formattedLabels = [];
        foreach ($dates as $date) {
            $dt = new \DateTime($date);
            $formattedLabels[] = $this->getShortDayName($dt->format('N')); 
        }

        $ordersOnline = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['pay_type.online' => 1])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $ordersCash = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['pay_type.place' => 1])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $deliveredOrders = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('status')
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['IN', 'status.title', ['Доставлен', 'Заказ выдан']])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $cancelledOrders = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('status')
            ->where(['>=', 'created_at', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['status.title' => 'Отменен'])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $onlineData = array_fill_keys($dates, 0);
        foreach ($ordersOnline as $item) {
            if (isset($onlineData[$item['date']])) { 
                $onlineData[$item['date']] = (int)$item['count'];
            }
        }

        $cashData = array_fill_keys($dates, 0);
        foreach ($ordersCash as $item) {
            if (isset($cashData[$item['date']])) {
                $cashData[$item['date']] = (int)$item['count'];
            }
        }

        $deliveredData = array_fill_keys($dates, 0);
        foreach ($deliveredOrders as $item) {
            if (isset($deliveredData[$item['date']])) {
                $deliveredData[$item['date']] = (int)$item['count'];
            }
        }

        $cancelledData = array_fill_keys($dates, 0);
        foreach ($cancelledOrders as $item) {
            if (isset($cancelledData[$item['date']])) {
                $cancelledData[$item['date']] = (int)$item['count'];
            }
        }

        return $this->render('index', [
            'labels' => $formattedLabels,
            'online' => array_values($onlineData),
            'cash' => array_values($cashData),
            'delivered' => array_values($deliveredData),
            'cancelled' => array_values($cancelledData),
        ]);
    }

    private function getShortDayName($dayNumber)
    {
        $days = [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс',
        ];

        return $days[$dayNumber] ?? '';
    }
}