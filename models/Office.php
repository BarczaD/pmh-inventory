<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Office extends ActiveRecord implements IdentityInterface
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

    public static function deleteOffice($id)
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $log = new \app\models\Log();
        $log->alert_level = 1;
        $log->event_type = $insert ? LogEvent::OFFICE_CREATE : LogEvent::OFFICE_UPDATE;
        $log->event_description = ($insert ? "Iroda létrehozva: " : "Iroda módosítva: ") . $this->name;
        $log->triggered_by = Yii::$app->user->id ?? 0;
        $log->log_date = date('Y-m-d H:i:s');

        if (!$log->save()) {
            throw new \yii\db\Exception("Log mentése sikertelen: " . json_encode($log->errors));
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $log = new \app\models\Log();
        $log->alert_level = 2;
        $log->event_type = LogEvent::OFFICE_DELETE;
        $log->event_description = "Iroda törölve: " . $this->name;
        $log->triggered_by = Yii::$app->user->id ?? 0;

        if (!$log->save(false)) {
            throw new \yii\db\Exception("Törlési log mentése sikertelen.");
        }
    }
}