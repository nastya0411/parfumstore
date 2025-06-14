<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $category_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex_id', 'count', 'category_id'], 'integer'],
            [['title'], 'safe'],
            [['price'], 'number'],
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
    public function search($params, $categoryId = null)
    {
        $query = Product::find();
    
        $query->innerJoinWith(['productCategories']); 
    
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
    
        $this->load($params);
    
        if ($categoryId !== null) {
            $this->category_id = $categoryId;
        }
    
        if (!$this->validate()) {
            return $dataProvider;
        }
    
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'sex_id' => $this->sex_id,
            'count' => $this->count,
        ]);
    
        $query->andFilterWhere(['like', 'title', $this->title]);
    
        if (!empty($this->category_id)) {
            $query->andWhere(['product_category.category_id' => $this->category_id]);
        }
    
        return $dataProvider;
    }
}
