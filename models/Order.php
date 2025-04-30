<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $address
 * @property string $phone
 * @property string $created_at
 * @property string $date
 * @property string $time
 * @property int $pay_type_id
 * @property int $status_id
 * @property int $user_id
 * @property int $amount
 * @property float $cost
 * @property string $other_reason
* @property int|null $pay_receipt

 * @property OrderItem[] $orderItems
 * @property PayType $payType
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'phone', 'date', 'time', 'pay_type_id', 'status_id', 'user_id'], 'required'],
            [['created_at', 'date', 'time'], 'safe'],
            [['pay_type_id', 'status_id', 'user_id', 'amount', 'pay_receipt'], 'integer'],
            [['cost'], 'number'],
            ['phone','match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'Телефон в формате +7(XXX)-XXX-XX-XX'],
            [['address', 'phone', 'other_reason'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Заказ №',
            'address' => 'Адрес доставки заказа',
            'phone' => 'Телефон получателя',
            'created_at' => 'Дата создания заказа',
            'date' => 'Дата получания заказа',
            'time' => 'Время получания заказа',
            'pay_type_id' => 'Способ оплаты',
            'status_id' => 'Статус заказа',
            'user_id' => 'Клиент',
            'amount' => 'Количество товаров в заказе',
            'cost' => 'Полная цена заказа',
            'other_reason' => 'Причина отмены заказа',
            'pay_receipt' => 'Оплата при получении', 
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
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
