<?php

namespace app\modules\shop\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;
use Yii;
use yii\db\Query;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pay_type_id', 'status_id', 'user_id', 'amount', 'pay_receipt'], 'integer'],
            [['address', 'phone', 'created_at', 'date', 'time', 'other_reason'], 'safe'],
            [['cost'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'date' => $this->date,
            'time' => $this->time,
            'pay_type_id' => $this->pay_type_id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'pay_receipt' => $this->pay_receipt,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'other_reason', $this->other_reason]);

        return $dataProvider;
    }


    public function orderCreate($id)
    {
        $query = (new Query())
        ->select([
            'cart.id as cart_id', 
            'cart.amount as cart_amount', 
            'cart.cost as cart_cost',
            'cart_item.id as item_id',
            'cart_item.amount as item_amount',
            'cart_item.cost as item_cost',
            'product.id as product_id',
            'product.title as product_title',
            'product.volume as product_volume',
            'product.price as product_price',
            '(SELECT photo FROM photo WHERE product_id = product.id LIMIT 1) as product_photo'
        ])
        ->from('cart')
        ->innerJoin('cart_item', 'cart.id = cart_item.cart_id')
        ->innerJoin('product', 'product.id = cart_item.product_id')
        ->where(['cart_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
