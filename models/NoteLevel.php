<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note_level".
 *
 * @property int $id
 * @property string $title
 *
 * @property ProductNoteLevel[] $productNoteLevels
 */
class NoteLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[ProductNoteLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNoteLevels()
    {
        return $this->hasMany(ProductNoteLevel::class, ['note_level_id' => 'id']);
    }
}
