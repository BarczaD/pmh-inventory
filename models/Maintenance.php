<?php

namespace app\models;

use app\models\forms\WorkstationForm;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Maintenance extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'maintenance';
    }

    public static function getMaintenances()
    {
        return static::find()->with();
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

    public function saveMaintenance()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save(false)) {
                throw new \Exception("Nem sikerült felvinni a Karbantartást.");
            }
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Regisztráció sikertelen: " . $e->getMessage(), __METHOD__);
            return false;
        }
    }

    public function processPost($post)
    {
        try {
            $post = $post['Maintenance'];

            $this->hostname = $post['hostname'];
            $this->hardware = intval($post['hardware']);
            $this->software = intval($post['software']);
            $this->date = $post['date'];
            $this->description = $post['description'] != "" ? $post['description'] : null;

            return true;
        } catch (\Exception $ex) {
            echo($ex->getMessage());
            return false;
        }
    }
    public function getMaintenance()
    {
        return $this->hasOne(Maintenance::class, ['id' => 'maintenance_id']);
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