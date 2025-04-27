<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_note_level".
 *
 * @property int $id
 * @property int $product_id
 * @property int $note_level_id
 *
 * @property NoteLevel $noteLevel
 * @property Product $product
 * @property ProductNoteLevelItem[] $productNoteLevelItems
 */
class ProductNoteLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_note_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'note_level_id'], 'required'],
            [['product_id', 'note_level_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['note_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => NoteLevel::class, 'targetAttribute' => ['note_level_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'note_level_id' => 'Note Level ID',
        ];
    }

    /**
     * Gets query for [[NoteLevel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNoteLevel()
    {
        return $this->hasOne(NoteLevel::class, ['id' => 'note_level_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[ProductNoteLevelItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNoteLevelItems()
    {
        return $this->hasMany(ProductNoteLevelItem::class, ['product_note_level_id' => 'id']);
    }

    public static function setProductNoteLevelItems($model)
    {

        // 'noteLevels' => [
        //     1 => [
        //         0 => '1'
        //         1 => '7'
        //         2 => '9'
        //     ]
        //     2 => [
        //         0 => '1'
        //         1 => '7'
        //         2 => '9'
        //     ]
        //     3 => [
        //         0 => '1'
        //         1 => '2'
        //         2 => '7'
        //     ]
        //     ]

        if (!empty($model->noteLevels)) {
            foreach ($model->noteLevels as $levelId => $noteIds) {
                if (!empty($noteIds)) {
                    $level = new ProductNoteLevel([
                        'product_id' => $model->id,
                        'note_level_id' => $levelId
                    ]);

                    if ($level->save()) {
                        foreach ($noteIds as $noteId) {
                            (new ProductNoteLevelItem([
                                'product_note_level_id' => $level->id,
                                'note_id' => $noteId
                            ]))->save();
                        }
                    }
                }
            }
        }
    }
}
