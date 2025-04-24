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
 *
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
            [['address', 'phone', 'date', 'time', 'pay_type_id', 'status_id', 'user_id', 'other_reason'], 'required'],
            [['created_at', 'date', 'time'], 'safe'],
            [['pay_type_id', 'status_id', 'user_id', 'amount'], 'integer'],
            [['cost'], 'number'],
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
            'id' => 'ID',
            'address' => 'Address',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'date' => 'Date',
            'time' => 'Time',
            'pay_type_id' => 'Pay Type ID',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'cost' => 'Cost',
            'other_reason' => 'Other Reason',
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
