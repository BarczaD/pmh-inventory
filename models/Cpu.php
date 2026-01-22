<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Cpu extends ActiveRecord
{
    public static function tableName()
    {
        return 'cpu';
    }

    public function rules()
    {
        return [
            [['brand', 'model'], 'required'],
            [['brand', 'model'], 'string', 'max' => 255],
            [['brand', 'model'], 'trim'],
        ];
    }

    /**
     * Automate metadata. This replaces registerCpu() and manual controller logic.
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->uploaded_by = Yii::$app->user->id;
            $this->upload_date = date("Y-m-d H:i:s");
        }

        return true;
    }
}