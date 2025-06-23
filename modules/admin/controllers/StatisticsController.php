<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order;
use app\models\OrderItem;
use app\models\Product;

class StatisticsController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $period = $request->get('period', 'week');

        list($startDateStr, $endDateStr, $dates, $title) = match ($period) {
            'week' => $this->getWeekRange(),
            'next_week' => $this->getPreviousWeekRange(),
            '2weeks' => $this->getTwoWeeksRange(),
            'month' => $this->getCurrentMonthRange(),
            'next_month' => $this->getPreviousMonthRange(),
            'quarter' => $this->getLastQuarterRange(),
            default => $this->getWeekRange(),
        };

        $formattedLabels = [];
        foreach ($dates as $date) {
            $dt = new \DateTime($date);
            $formattedLabels[] = $this->getShortDayName($dt->format('N'));
        }

        $ordersOnline = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['pay_type.online' => 1])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $ordersCash = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['pay_type.place' => 1])
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

        $deliveredOrders = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('status')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['IN', 'status.title', ['Доставлен', 'Заказ выдан']])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

        $cancelledOrders = Order::find()
            ->select(['DATE(created_at) as date', 'COUNT(*) as count'])
            ->innerJoinWith('status')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['status.title' => 'Отменен'])
            ->groupBy('DATE(created_at)')
            ->asArray()
            ->all();

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

        $orderIds = Order::find()
            ->select('id')
            ->where(['>=', 'created_at', $startDateStr])
            ->column();

        $topProducts = OrderItem::find()
            ->select(['product_id', 'SUM(amount) as total_amount'])
            ->where(['order_id' => $orderIds])
            ->groupBy('product_id')
            ->orderBy(['total_amount' => SORT_DESC])
            ->limit(5)
            ->asArray()
            ->all();

        $topProductLabels = [];
        $topProductData = [];

        foreach ($topProducts as $item) {
            $product = Product::findOne($item['product_id']);
            $topProductLabels[] = $product ? $product->title : 'Неизвестный товар';
            $topProductData[] = (int)$item['total_amount'];
        }

        $deliveryOrders = Order::find()
            ->select(['HOUR(time) as hour', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['pay_type.online' => 1])
            ->groupBy('hour')
            ->orderBy('hour')
            ->asArray()
            ->all();

        $pickupOrders = Order::find()
            ->select(['HOUR(time) as hour', 'COUNT(*) as count'])
            ->innerJoinWith('payType')
            ->where(['>=', 'created_at', $startDateStr])
            ->andWhere(['pay_type.place' => 1])
            ->andWhere(['pay_type.online' => 0])
            ->groupBy('hour')
            ->orderBy('hour')
            ->asArray()
            ->all();

        $timeLabels = [];
        $deliveryData = array_fill(0, 24, 0);
        $pickupData = array_fill(0, 24, 0);

        foreach ($deliveryOrders as $item) {
            $deliveryData[(int)$item['hour']] = (int)$item['count'];
        }

        foreach ($pickupOrders as $item) {
            $pickupData[(int)$item['hour']] = (int)$item['count'];
        }

        for ($h = 0; $h < 24; $h++) {
            $timeLabels[] = "$h:00";
        }

        return $this->render('index', [
            'labels' => $formattedLabels,
            'online' => array_values($onlineData),
            'cash' => array_values($cashData),
            'delivered' => array_values($deliveredData),
            'cancelled' => array_values($cancelledData),
            'topProductsLabels' => $topProductLabels,
            'topProductsData' => $topProductData,
            'timeLabels' => $timeLabels,
            'deliveryData' => $deliveryData,
            'pickupData' => $pickupData,
            'title' => $title,
        ]);
    }

    private function getWeekRange(): array
    {
        $startDateStr = date('Y-m-d', strtotime('-7 days'));
        $endDateStr = date('Y-m-d');
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "последние 7 дней"];
    }

    private function getPreviousWeekRange(): array
    {
        $startDateStr = date('Y-m-d', strtotime('-14 days'));
        $endDateStr = date('Y-m-d', strtotime('-7 days'));
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "предыдущую неделю"];
    }

    private function getTwoWeeksRange(): array
    {
        $startDateStr = date('Y-m-d', strtotime('-14 days'));
        $endDateStr = date('Y-m-d');
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "последние 2 недели"];
    }

    private function getCurrentMonthRange(): array
    {
        $startDateStr = date('Y-m-01');
        $endDateStr = date('Y-m-t');
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "текущий месяц"];
    }

    private function getPreviousMonthRange(): array
    {
        $startDateStr = date('Y-m-01', strtotime("first day of last month"));
        $endDateStr = date('Y-m-t', strtotime("last day of last month"));
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "предыдущий месяц"];
    }

    private function getLastQuarterRange(): array
    {
        $startDateStr = date('Y-m-d', strtotime("-90 days"));
        $endDateStr = date('Y-m-d');
        $dates = $this->generateDateRange($startDateStr, $endDateStr);
        return [$startDateStr, $endDateStr, $dates, "последний квартал"];
    }

    private function generateDateRange(string $start, string $end): array
    {
        $dates = [];
        $current = new \DateTime($start);
        $end = new \DateTime($end);
        while ($current <= $end) {
            $dates[] = $current->format('Y-m-d');
            $current->modify('+1 day');
        }
        return $dates;
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
