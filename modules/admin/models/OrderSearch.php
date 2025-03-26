<?php
 
 namespace app\modules\admin\models;
 
 use yii\base\Model;
 use yii\data\ActiveDataProvider;
 use app\models\Order;
 
 /**
  * OrderSearch represents the model behind the search form of `app\models\Application`.
  */
 class OrderSearch extends Order
 {
     /**
      * {@inheritdoc}
      */
     public function rules()
     {
         return [
             [['id', 'service_id', 'pay_type_id', 'status_id', 'user_id'], 'integer'],
             [['address', 'phone', 'created_at', 'date', 'time', 'other'], 'safe'],
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
             'service_id' => $this->service_id,
             'pay_type_id' => $this->pay_type_id,
             'status_id' => $this->status_id,
             'user_id' => $this->user_id,
         ]);
 
         $query->andFilterWhere(['like', 'address', $this->address])
             ->andFilterWhere(['like', 'phone', $this->phone])
             ->andFilterWhere(['like', 'other', $this->other]);
 
         return $dataProvider;
     }
 }