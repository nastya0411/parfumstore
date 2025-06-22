<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property Order[] $orders
 */
class PayType extends \yii\db\ActiveRecord
{
    // public static function getPaymentTypesList()
    // {
    //     return [
    //         1 => 'Онлайн оплата',
    //         2 => 'Оплата при получении'
    //     ];
    // }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['online', 'place'], 'integer'],
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
            'online' => 'Choice Online',
            'place' => 'Choice Place',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['pay_type_id' => 'id']);
    }

    public function getPayId(string $title): int|null
    {
        return static::findOne(["title" => $title])?->id;
    }


    public static function getPayTypesOnline()
    {
        return self::find()
            ->select('title')
            ->where(['online' => 1])
            ->indexBy('id')
            ->column();
    }

    public static function getPayTypesPlace()
    {
        return self::find()
            ->select('title')
            ->where(['place' => 1])
            ->indexBy('id')
            ->column();
    }

    public static function getPayTypes()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column();
    }


    public function getIsQR()
    {
        return $this->id == $this->getPayId("QR код");
    }
}
