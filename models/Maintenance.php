<?php

namespace app\models;

use app\models\forms\Workstation;
use yii\db\ActiveRecord;

class Maintenance extends ActiveRecord
{
    public static function tableName()
    {
        return 'maintenance';
    }

    public function rules()
    {
        return [
            [['date', 'workstation_id'], 'required'],
            [['date'], 'safe'],
            [['workstation_id'], 'integer'],
            [['hardware', 'software'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function getWorkstation()
    {
        return $this->hasOne(Workstation::class, ['id' => 'workstation_id']);
    }
}