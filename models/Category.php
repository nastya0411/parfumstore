<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 *
 * @property ProductCategory[] $productCategories 
 * @property Photo[] $photos
 */
class Category extends \yii\db\ActiveRecord
{

    public $imageFile;
    public $photoCategories;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'imageFile' => 'Изображение категории',
        ];
    }

    /**
     * Gets query for [[ProductCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['category_id' => 'id']);
    }

    public function getPhotos()
    {
        return $this->hasMany(PhotoCategory::class, ['category_id' => 'id']);
    }


    public static function getCategories()
    {
        return self::find()
            ->select('title')
            ->indexBy('id')
            ->column();
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {

                $this->photoCategories = time() . '_' . Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs('img/' . $this->photoCategories);
            }
            return true;
        } else {
            return false;
        }
    }
}
