<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Product $product
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            [['product_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    
    public static function setProductCategory($model)
    {
        $category_db = ProductCategory::find()
            ->select('category_id')
            ->where(['product_id' => $model->id])
            ->indexBy('category_id')
            ->column()        
            ;

        if ($category_db) {
            if ($diff = array_diff($category_db, $model->categories)) {
                ProductCategory::deleteAll([
                    'category_id' => $diff,
                    'product_id' => $model->id,
                ]);
            }
        }

        foreach ($model->categories as $val) {            
            if (!in_array((int)$val, $category_db)) {
                $productCategory = new ProductCategory();
                $productCategory->category_id = $val;
                $productCategory->product_id = $model->id;
                $productCategory->save();
            }
        }
    }
}
