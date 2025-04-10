<?php

namespace app\models;

use yii\db\ActiveRecord;

class Colleague extends ActiveRecord
{
    public static function tableName()
    {
        return 'colleague';
    }

    public function rules()
    {
        return [
            [['name', 'department', 'group'], 'required'],
            [['archived'], 'boolean'],
            [['name', 'department', 'group'], 'string', 'max' => 255],
        ];
    }
}