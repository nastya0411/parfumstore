<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

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
        try {
            $transation = Yii::$app->db->beginTransaction();
            
            $productNoteLevelDb = ProductNoteLevel::find()
                ->select('note_level_id')
                ->where(['product_id' => $model->id])
                ->indexBy('id')
                ->column();

            if ($productNoteLevelDb) {
                if ($diff = array_diff($productNoteLevelDb, array_keys($model->noteLevels))) {
                    ProductNoteLevel::deleteAll([
                        'product_id' => $model->id,
                        'note_level_id' => array_values($diff)
                    ]);
                } else {
                    foreach ($productNoteLevelDb as $pr_n_l_id => $level) {
                        $productNoteLevelItemDb = ProductNoteLevelItem::find()
                            ->select('note_id')
                            ->where(['product_note_level_id' => $pr_n_l_id])
                            ->indexBy('id')
                            ->column();

                        $level_user = isset($model->noteLevels[$level]) && !empty($model->noteLevels[$level])
                            ? $model->noteLevels[$level]
                            : [];

                        if ($diff = array_diff($productNoteLevelItemDb, $level_user)) {
                            ProductNoteLevelItem::deleteAll([
                                'id' => array_keys($productNoteLevelItemDb)
                            ]);
                        }
                    }
                }
            }

            if (!empty($model->noteLevels)) {
                foreach ($model->noteLevels as $levelId => $noteIds) {
                    if (!empty($noteIds)) {
                        $level = ProductNoteLevel::findOne([
                            'product_id' => $model->id,
                            'note_level_id' => $levelId
                        ]);

                        if (!$level) {
                            $level = new ProductNoteLevel([
                                'product_id' => $model->id,
                                'note_level_id' => $levelId
                            ]);

                            $level->save();
                        }

                        foreach ($noteIds as $noteId) {
                            if (!ProductNoteLevelItem::findOne(['product_note_level_id' => $level->id, 'note_id' => $noteId])) {
                                (new ProductNoteLevelItem([
                                    'product_note_level_id' => $level->id,
                                    'note_id' => $noteId
                                ]))->save();
                            }
                        }
                    }
                }
            }
            
            $transation->commit();
        } catch (\Exception $e) {
            $transation->rollBack();
        }
    }
}