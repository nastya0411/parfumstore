<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 *
 * @property ProductNotes[] $productNotes
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
            [['title', 'price'], 'required'],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[ProductNotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNotes()
    {
        return $this->hasMany(ProductNotes::class, ['product_id' => 'id']);
    }
}
