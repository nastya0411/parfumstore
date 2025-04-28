<?php

namespace app\modules\shop\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cart;
use app\models\CartItem;
use Yii;
use yii\db\Query;

/**
 * CartSearch represents the model behind the search form of `app\models\Cart`.
 */
class CartSearch extends Cart
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount'], 'integer'],
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
            'product.price as product_price',
            '(SELECT photo FROM photo WHERE product_id = product.id LIMIT 1) as product_photo'
        ])
        ->from('cart')
        ->innerJoin('cart_item', 'cart.id = cart_item.cart_id')
        ->innerJoin('product', 'product.id = cart_item.product_id')
        ->where(['cart.user_id' => Yii::$app->user->id]);

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
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
        ]);

        return $dataProvider;
    }
}
