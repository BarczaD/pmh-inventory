<?php

namespace app\models;

use yii\db\ActiveRecord;

class Office extends ActiveRecord
{
    public static function tableName()
    {
        return 'office';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}