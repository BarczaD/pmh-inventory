<?php

namespace app\models;

use yii\db\ActiveRecord;

class Monitor extends ActiveRecord
{
    public static function tableName()
    {
        return 'monitor';
    }

    public function rules()
    {
        return [
            [['brand', 'model', 's_n', 'i_n'], 'required'],
            [['description'], 'string'],
            [['brand', 'model', 's_n', 'i_n'], 'string', 'max' => 255],
        ];
    }
}