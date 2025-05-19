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
 * @property int $volume 
 * @property string $description
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
    public $categories = [];
    // public $allNotes;
    public $noteLevels = [];


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

 	        [['title', 'price', 'sex_id', 'count', 'volume', 'description'], 'required'],
		    [['stars', 'price'], 'number'],
            [['sex_id', 'count', 'volume'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sex::class, 'targetAttribute' => ['sex_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['categories'], 'safe'],
            [['noteLevels'], 'safe'],
            // [['allNotes'], 'safe'],

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
            'stars' => 'Звездочки',
            'count' => 'Количество',
            'imageFile' => 'Изображение товара',
            'categories' => 'Категория товара',
            'volume' => 'Объем товара в мл',
            'description' => 'Описание товара'
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


    public function saveNotes()
    {
        if (!empty($this->noteLevels)) {
            foreach ($this->noteLevels as $levelId => $noteIds) {
                if (!empty($noteIds)) {
                    $productNoteLevel = new ProductNoteLevel();
                    $productNoteLevel->product_id = $this->id;
                    $productNoteLevel->note_level_id = $levelId;
                    if ($productNoteLevel->save()) {
                        foreach ($noteIds as $noteId) {
                            $item = new ProductNoteLevelItem();
                            $item->product_note_level_id = $productNoteLevel->id;
                            $item->note_id = $noteId;
                            $item->save();
                        }
                    }
                }
            }
        }
    }
}
