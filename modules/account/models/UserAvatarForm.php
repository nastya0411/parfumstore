<?php

namespace app\modules\account\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UserAvatarForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $avatarImage;

    public function rules()
    {
        return [
            [['avatarImage'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'avatarImage' => 'Изображение',
        ];
    }

    public function upload(?string $fileNameOld = null): string|bool
    {
        if ($this->validate()) {
            $fileName = Yii::$app->user->id . "_"
                . Yii::$app->security->generateRandomString()
                . "."
                . $this->avatarImage->extension;
            $this->avatarImage->saveAs('img/' . $fileName);
            if (!empty($fileNameOld)) {
                unlink("img/" . $fileNameOld);
            }
            return $fileName;
        } else {
            return false;
        }
    }
}
