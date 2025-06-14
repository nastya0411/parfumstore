<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stars_user".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property float $stars
 *
 * @property Product $product
 * @property User $user
 */
class StarsUser extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stars_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stars'], 'default', 'value' => 0.0],
            [['product_id', 'user_id'], 'required'],
            [['product_id', 'user_id'], 'integer'],
            [['stars'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'stars' => 'Stars',
        ];
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
