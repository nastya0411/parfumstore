<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notes_prop".
 *
 * @property int $id
 * @property string $title
 * @property string $value
 * @property int $notes_id
 *
 * @property Notes $notes
 */
class NotesProp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notes_prop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'value', 'notes_id'], 'required'],
            [['notes_id'], 'integer'],
            [['title', 'value'], 'string', 'max' => 255],
            [['notes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notes::class, 'targetAttribute' => ['notes_id' => 'id']],
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
            'value' => 'Value',
            'notes_id' => 'Notes ID',
        ];
    }

    /**
     * Gets query for [[Notes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasOne(Notes::class, ['id' => 'notes_id']);
    }
}
