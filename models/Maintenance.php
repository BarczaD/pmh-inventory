<?php

namespace app\models;

use app\models\forms\Workstation;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Maintenance extends ActiveRecord implements IdentityInterface
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}