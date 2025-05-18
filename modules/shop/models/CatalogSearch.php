<?php

namespace app\modules\shop\models;

use app\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductCategory;
use Yii;

/**
 * CatalogSearch represents the model behind the search form of `app\models\ProductCategory`.
 */
class CatalogSearch extends Product
{
    public $category_id;
    public $product;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['product'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория аромата',
            'product' => 'Товар',
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
        $query = Product::find()
            ->joinWith("productCategories")
            ->where([">", "count", 0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (in_array("CatalogSearch", array_keys($params))) {
            $this->load($params);
        } else {
            $this->load($params, "");
        }



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query
            ->andFilterWhere([
                'id' => $this->id,
                'product_category.category_id' => $this->category_id,
            ])
            ->andFilterWhere([
                'like',
                'product.title',
                $this->product
            ]);


        return $dataProvider;
    }
}
