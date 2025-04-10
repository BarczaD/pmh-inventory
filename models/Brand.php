<?php

namespace app\models;

use yii\db\ActiveRecord;

class Brand extends ActiveRecord
{
    public static function tableName()
    {
        return 'brand';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}