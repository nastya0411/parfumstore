<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_category_id
 * @property float $total_price
 * @property int $status_id
 * @property string $address
 * @property string $phone
 * @property string $created_at
 * @property string $date
 * @property string $time
 * @property string $other_reason
 *
 * @property ProductCategory $productCategory
 * @property Status $status
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    const SCENARIO_ORDER = 'order';
     const SCENARIO_CANCEL = 'cancel';
     const SCENARIO_OTHER = 'other';
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
            [['user_id', 'product_category_id', 'total_price', 'status_id', 'address', 'phone', 'date', 'time', 'other_reason', 'pay_type_id'], 'required'],
            [['user_id', 'product_category_id', 'status_id', 'pay_type_id',], 'integer'],
            [['total_price'], 'number'],
            [['created_at', 'date', 'time'], 'safe'],
            [['address', 'phone', 'other_reason'], 'string', 'max' => 255],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::class, 'targetAttribute' => ['product_category_id' => 'id']],
            ['phone','match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'Телефон в формате +7(XXX)-XXX-XX-XX'],

            ['order_id', 'required', 'on' => self::SCENARIO_ORDER],
            ['check', 'boolean'],
            ['other', 'required', 'on' => self::SCENARIO_OTHER],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ заявки',
            'user_id' => 'Клиент',
            'product_category_id' => 'Заказ',
            'total_price' => 'Полная цена заказа',
            'status_id' => 'Статус заказа',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'created_at' => 'Время создания',
            'date' => 'Дата получения заказа',
            'pay_type_id' => 'Тип оплаты',
            'time' => 'Время получения заказа',
            'other_reason' => 'Причина отмены заказа',
        ];
    }

    /**
     * Gets query for [[ProductCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::class, ['id' => 'product_category_id']);
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
