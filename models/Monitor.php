<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Monitor extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'monitor';
    }



    public function rules()
    {
        return [
            [['brand', 'model', 's_n', 'i_n'], 'required'],
            [['description'], 'string'],
            [['brand', 'model', 's_n', 'i_n'], 'string', 'max' => 255],
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

    public static function getMonitors()
    {
        return static::find()->with();
    }

    public static function findMonitorBySerial($s_n)
    {
        return static::findOne(['s_n' => $s_n]);
    }

    public static function deleteMonitor($id)
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
        $log->event_type = $insert ? LogEvent::MONITOR_CREATE : LogEvent::MONITOR_UPDATE;
        $log->event_description = ($insert ? "Monitor létrehozva: " : "Monitor módosítva: {$this->brand} {$this->model}");
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
        $log->event_type = LogEvent::MONITOR_DELETE;
        $log->event_description = "Monitor törölve: {$this->brand} {$this->model}";
        $log->triggered_by = Yii::$app->user->id ?? 0;

        if (!$log->save(false)) {
            throw new \yii\db\Exception("Törlési log mentése sikertelen.");
        }
    }

}