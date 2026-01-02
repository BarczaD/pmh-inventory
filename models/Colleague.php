<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;

class Colleague extends ActiveRecord implements IdentityInterface
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

    public static function getColleagues()
    {
        return static::find()->with();
    }

    public function getColleague()
    {
        return $this->hasOne(Colleague::class, ['id' => 'colleague_id']);
    }


    public static function deleteColleague($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $model = static::findOne($id);
        if ($model) {
            try {
                $model->delete();
                $transaction->commit();
                return true;
            } catch (\Throwable $th) {
                $transaction->rollBack();
                throw $th;
            }
        }
    }

    public function toggleArchive()
    {
        $newValue = ($this->archived == 1) ? 0 : 1;
        return $this->updateAttributes(['archived' => $newValue]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            return parent::save($runValidation, $attributeNames);
        }

        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }

        return (bool)$this->updateAttributes($this->getDirtyAttributes($attributeNames));
    }

}