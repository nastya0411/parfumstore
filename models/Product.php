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
 * @property OrderItem[] $orderItems
 * @property Photo[] $photos
 * @property ProductCategory[] $productCategories
 * @property ProductNoteLevel[] $productNoteLevels
 * @property Sex $sex
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $photoProduct;

    public $categories;


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
            [['title', 'price', 'sex_id', 'count', 'categories'], 'required'],
            [['price'], 'number'],
            [['sex_id', 'count'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sex::class, 'targetAttribute' => ['sex_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['categories'], 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер товара',
            'title' => 'Название',
            'price' => 'Цена',
            'sex_id' => 'Для кого',
            'count' => 'Количество',
            'imageFile' => 'Изображение товара',
            'productCategories' => 'Категория товара',
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
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
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



    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {

                $this->photoProduct = time() . '_' . Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs('img/' . $this->photoProduct);
            }
            return true;
        } else {
            return false;
        }
    }
}
