<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Cpu extends ActiveRecord implements IdentityInterface
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

    public function registerCpu()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save(false)) {
                throw new \Exception("Nem sikerült felvinni a CPU-t.");
            }
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Regisztráció sikertelen: " . $e->getMessage(), __METHOD__);
        }
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