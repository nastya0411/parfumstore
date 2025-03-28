<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

class OrderSearch extends Order
{
    // Свойства для поиска
    public $user_id;
    public $status_id;
    public $address;
    public $phone;
    public $date;
    public $time;
    public $product_category_id;
    public $pay_type_id;
    
    public function rules()
    {
        return [
            [['id', 'user_id', 'status_id', 'product_category_id', 'pay_type_id'], 'integer'],
            [['address', 'phone', 'date', 'time'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Условия фильтрации
        $query->andFilterWhere([
            'id' => $this->id,
            'product_category_id' => $this->product_category_id,
            'pay_type_id' => $this->pay_type_id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'DATE(date)' => $this->date ? date('Y-m-d', strtotime($this->date)) : null,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
              ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}