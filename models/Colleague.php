<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Colleague extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'colleague';
    }

    public static function getColleagues()
    {
        return static::find()->with();
    }

    public function rules()
    {
        return [
            [['name', 'department', 'group'], 'required'],
            [['archived'], 'boolean'],
            [['name', 'department', 'group'], 'string', 'max' => 255],
        ];
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

    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }
}