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
    public $cardNumber;
    public $expiry;
    public $cvv;
    public $cardHolder;
    const SCENARIO_CANCEL = 'cancel';

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
            ['pay_receipt', 'boolean'],
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'Телефон в формате +7(XXX)-XXX-XX-XX'],
            [['address', 'phone', 'other_reason'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['cardNumber', 'expiry', 'cvv', 'cardHolder'], 'required', 'on' => 'payment'],
            [['cardNumber'], 'string', 'length' => 19],
            [['expiry'], 'string', 'length' => 5],
            [['cvv'], 'string', 'length' => 3],
            [['cardHolder'], 'string', 'max' => 255],
            ['other_reason', 'required', 'on' => self::SCENARIO_CANCEL]
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
            'created_at' => 'Дата и время создания заказа',
            'date' => 'Дата получания заказа',
            'time' => 'Время получания заказа',
            'pay_type_id' => 'Способ оплаты',
            'status_id' => 'Статус заказа',
            'user_id' => 'Клиент',
            'amount' => 'Количество товаров в заказе',
            'cost' => 'Полная цена заказа',
            'other_reason' => 'Причина отмены заказа',
            'pay_receipt' => 'Оплата при получении',
            'cardNumber' => 'Номер карты',
            'cvv' => 'CVV',
            'expiry' => 'Срок действия карты',
            'cardHolder' => 'Имя владельца карты',

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


    // public function sendMailTest($id)
    // {
    //     $model = $this;

    //     Yii::$app->mailer->htmlLayout = '@app/mail/layouts/html';

    //     if (Yii::$app->mailer
    //         ->compose('mail', [])
    //         ->setFrom('parfumstore_info@mail.ru')
    //         ->setTo('parfumstore_info@mail.ru')
    //         ->setSubject('Уведомление о статусе заказа')
    //         ->send()
    //     ) {
    //         Yii::$app->session->setFlash('success', 'send mail');
    //     } else {
    //         Yii::$app->session->setFlash('error', 'error send mail');
    //     };
    //     return $this->redirect('index');
    // }

    public function sendOfd(?string $userMail = null)
    {
        Yii::$app->mailer->htmlLayout = '@app/mail/layouts/html';        
        try {
            $result = Yii::$app->mailer
                ->compose('ofd', [
                    'model' => $this,                    
                    'orderDate' => Yii::$app->formatter->asDate($this->date),
                    'orderTime' => Yii::$app->formatter->asTime($this->time),
                    "items" => $this->orderItems
                ])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
                ->setTo($userMail ?? $this->user->email)
                ->setCc('parfumstore_info@mail.ru')
                ->setSubject("Чек оплаты заказа #{$this->id} от " 
                    . Yii::$app->formatter->asDate($this->date, "php:m.d.Y"))
                ->send();
            if (!$result) {
                Yii::$app->session->setFlash('error', 'Ошибка отправки электронного письма!');
                Yii::error("Не удалось отправить письмо для заказа #{$this->id}");
            } else {
                Yii::$app->session->setFlash('info', 'На вашу почту отправлена актуальная информация о заказе!');
            }
            return $result;
        } catch (\Exception $e) {
            Yii::error("Ошибка при отправке письма: " . $e->getMessage());
            var_dump($e->getMessage());
            die;
            return false;
        }
    }

    public function sendMail()
    {
        Yii::$app->mailer->htmlLayout = '@app/mail/layouts/html';
        $status = Status::findOne($this->status_id);
        try {
            $result = Yii::$app->mailer
                ->compose('mail', [
                    'model' => $this,
                    'status' => $status,
                    'orderDate' => Yii::$app->formatter->asDate($this->date),
                    'orderTime' => Yii::$app->formatter->asTime($this->time),
                ])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
                ->setTo($userMail ?? $this->user->email)
                ->setCc('parfumstore_info@mail.ru')
                ->setSubject("Изменение статуса заказа #{$this->id}")
                ->send();

            if (!$result) {
                Yii::$app->session->setFlash('error', 'Ошибка отправки электронного письма!');
                Yii::error("Не удалось отправить письмо для заказа #{$this->id}");
            } else {
                Yii::$app->session->setFlash('info', 'На вашу почту отправлена актуальная информация о заказе!');
            }
            return $result;
        } catch (\Exception $e) {
            Yii::error("Ошибка при отправке письма: " . $e->getMessage());
            var_dump($e->getMessage());            
            return false;
        }
    }


    public static function make()
    {
        $q = "delete o from `order` o "
            . "left join order_item i on i.order_id = o.id "
            . "where "
            . "i.id is null";

        Yii::$app->db->createCommand($q)->execute();
        $users = User::find()->asArray()->all();
        $date_on = time() - 3 * 30 * 24 * 60 * 60;
        $date_off = time();
        $pay_type = PayType::find()->select('id')->indexBy('id')->column();
        $status = Status::find()->select('id')->indexBy('id')->column();
        for ($i = 0; $i < 100; $i++) {
            var_dump($i);
            foreach ($users as $user) {
                $count = rand(1, 5);
                for ($c = 0; $c < $count; $c++) {
                    $order = new self();
                    $order->user_id = $user["id"];
                    $p = rand(1, 9);
                    $order->phone = "+7($p$p$p)-$p$p$p-$p$p-$p$p";
                    $order->address = "город доставки, улица доставки, N дома N квартиры";
                    $time = rand($date_on, $date_off);
                    $order->created_at = Yii::$app->formatter->asDatetime($time, "php:Y-m-d H:m:s");
                    $order->date = Yii::$app->formatter->asDate($time, "php:Y-m-d");
                    $order->time = Yii::$app->formatter->asTime($time, "php:H:m:s");
                    $order->pay_type_id = array_rand($pay_type);
                    $order->status_id = array_rand($status);
                    $order->pay_receipt = rand(0, 1);
                    $order->amount = 0;
                    $order->cost = 0;
                    $order->pay_receipt = rand(0, 1);
                    $order->save();

                    $items = rand(1, 5);
                    $sum = 0;
                    $amount = 0;
                    $products = Product::find()->select('id')->indexBy('id')->column();
                    for ($item = 0; $item < $items; $item++) {
                        $i_count = rand(1, 10);
                        $o_item = new OrderItem();
                        $o_item->order_id = $order->id;
                        $o_item->product_id = array_rand($products);
                        $cost = Product::findOne($o_item->product_id)->price * $i_count;
                        $o_item->amount = $i_count;
                        $o_item->cost = $cost;
                        $amount += $i_count;
                        $sum += $cost;
                        $o_item->save();
                    }

                    $order->amount = $amount;
                    $order->cost = $sum;
                    $order->save();
                }
            }
        }

        return "ok";
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (Yii::$app->id !== 'basic-console') {
            $this->sendMail();
            if (str_contains(Status::getStatuses()[$this->status_id], "Оплачен")) {
                $this->sendOfd(Yii::$app->params["userEmail"]);
            }
        }
    }
}
