<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo_category".
 *
 * @property int $id
 * @property string $photo
 * @property int $category_id
 *
 * @property Category $category
 */
class PhotoCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public static function setCategoryPhoto($model)
    {
        $photo = new PhotoCategory();
        $photo->category_id = $model->id;
        $photo->photo = $model->photoCategories;
        return $photo->save();
    }

}
