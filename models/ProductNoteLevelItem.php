<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_note_level_item".
 *
 * @property int $id
 * @property int $product_note_level_id
 * @property int $note_id
 *
 * @property Note $note
 * @property ProductNoteLevel $productNoteLevel
 */
class ProductNoteLevelItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_note_level_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_note_level_id', 'note_id'], 'required'],
            [['product_note_level_id', 'note_id'], 'integer'],
            [['product_note_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductNoteLevel::class, 'targetAttribute' => ['product_note_level_id' => 'id']],
            [['note_id'], 'exist', 'skipOnError' => true, 'targetClass' => Note::class, 'targetAttribute' => ['note_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_note_level_id' => 'Product Note Level ID',
            'note_id' => 'Note ID',
        ];
    }

    /**
     * Gets query for [[Note]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNote()
    {
        return $this->hasOne(Note::class, ['id' => 'note_id']);
    }

    /**
     * Gets query for [[ProductNoteLevel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNoteLevel()
    {
        return $this->hasOne(ProductNoteLevel::class, ['id' => 'product_note_level_id']);
    }
}
