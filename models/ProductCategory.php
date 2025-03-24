<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property int $product_notes_id
 * @property int $category_id
 *
 * @property Catalog[] $catalogs
 * @property Category $category
 * @property Order[] $orders
 * @property ProductNotes $productNotes
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
            [['product_notes_id', 'category_id'], 'required'],
            [['product_notes_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['product_notes_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductNotes::class, 'targetAttribute' => ['product_notes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_notes_id' => 'Product Notes ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Catalogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogs()
    {
        return $this->hasMany(Catalog::class, ['product_category_id' => 'id']);
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
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['product_category_id' => 'id']);
    }

    /**
     * Gets query for [[ProductNotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNotes()
    {
        return $this->hasOne(ProductNotes::class, ['id' => 'product_notes_id']);
    }
}
