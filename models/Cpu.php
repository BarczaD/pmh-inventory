<?php

namespace app\models;

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
        ];
    }
}