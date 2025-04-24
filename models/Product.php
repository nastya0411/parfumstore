<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int $sex_id
 * @property int $count
 *
 * @property CartItem[] $cartItems
 * @property OrderShopItem[] $orderShopItems
 * @property Photo[] $photos
 * @property ProductCategory[] $productCategories
 * @property ProductNoteLevel[] $productNoteLevels
 * @property Sex $sex
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'sex_id', 'count'], 'required'],
            [['price'], 'number'],
            [['sex_id', 'count'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sex::class, 'targetAttribute' => ['sex_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'sex_id' => 'Sex ID',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderShopItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderShopItems()
    {
        return $this->hasMany(OrderShopItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductNoteLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNoteLevels()
    {
        return $this->hasMany(ProductNoteLevel::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Sex]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSex()
    {
        return $this->hasOne(Sex::class, ['id' => 'sex_id']);
    }
}
