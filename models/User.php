<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property int $role_id
 * @property string|null $auth_key
 *
 * @property Cart[] $carts
 * @property Order[] $orders
 * @property Role $role
 */
class User extends ActiveRecord implements IdentityInterface
{
    public ?string $newPassword = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'full_name', 'email', 'phone', 'role_id'], 'required'],
            [['role_id'], 'integer'],
            [['login', 'password', 'full_name', 'email', 'phone', 'auth_key', "newPassword", "address", "avatar"], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'full_name' => 'ФИО',
            'email' => 'Адрес электронной почты',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'avatar' => '"Автарка" пользователя',
            'newPassword' => 'Пароль',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }
    public function getStarsUsers()
    {
        return $this->hasMany(StarsUser::class, ['user_id' => 'id']);
    }
    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername(string $login): null|object
    {
        return self::findOne(['login' => $login]);
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getIsAdmin(): bool
    {
        return $this->role_id == Role::getRoleId('admin');
    }


    public function setPassword(): void
    {
        $this->password == Yii::$app->security->generatePasswordHash($this->newPassword);
    }
}
