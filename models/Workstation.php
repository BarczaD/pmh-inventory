<?php
namespace app\models;

use app\models\Brand;
use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Office;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Workstation extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'workstation';
    }

    public function rules()
    {
        return [
            [['hostname', 'brand_id', 'cpu_id', 'ram', 'os'], 'required'],
            [['brand_id', 'cpu_id', 'colleague_id', 'monitor_id1', 'monitor_id2'], 'integer'],
            [['description', 'software_list', 'bitlocker_code', 'ms_office_license', 'hostname', 'os'], 'string'],
            [['monitor_id1', 'monitor_id2', 'description', 'colleague_id'], 'default', 'value' => null],
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

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getColleague()
    {
        return $this->hasOne(Colleague::class, ['id' => 'colleague_id']);
    }

    public function getCpu()
    {
        return $this->hasOne(Cpu::class, ['id' => 'cpu_id']);
    }

    public function getMonitor()
    {
        return $this->hasOne(Monitor::class, ['id' => 'monitor_id1']);
    }

    public function getOffice()
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
    }

    public function getAnydeskCode()
    {
        return $this->attributes['anydesk_code'];
    }

    public function saveWorkstation()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->uploaded_by = Yii::$app->user->id;
            date_default_timezone_set('Europe/Budapest');
            $this->upload_date = date("Y-m-d h:i:s");
            if (!$this->save()) {
                throw new \Exception("DB hiba: nem sikerült rögzíteni a munkaállomást!");
            }
            $transaction->commit();
            return true;
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            Yii::error($ex->getMessage());
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Only run this on new records (Create)
        if ($this->isNewRecord) {
            $this->uploaded_by = Yii::$app->user->id;
            // Use standard DB format. Timezone should be set in config/web.php, not here!
            $this->upload_date = date('Y-m-d H:i:s');
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $log = new \app\models\Log();
        $log->alert_level = 1;
        $log->event_type = $insert ? LogEvent::WORKSTATION_CREATE : LogEvent::WORKSTATION_UPDATE;
        $log->event_description = ($insert ? "Új munkaállomás: " : "Munkaállomás módosítva: ") . "{$this->hostname}";
        $log->triggered_by = Yii::$app->user->id ?? 0;
        $log->log_date = date('Y-m-d H:i:s');

        if (!$log->save()) {
            throw new \yii\db\Exception("Log mentése sikertelen: " . json_encode($log->errors));
        }
    }

    /**
     * Handles Logging for Deletion
     */
    public function afterDelete()
    {
        parent::afterDelete();

        $log = new \app\models\Log();
        $log->alert_level = 2;
        $log->event_type = LogEvent::WORKSTATION_DELETE;
        $log->event_description = "Munkállomás törölve: {$this->hostname}";
        $log->triggered_by = Yii::$app->user->id ?? 0;

        if (!$log->save(false)) {
            throw new \yii\db\Exception("Törlési log mentése sikertelen.");
        }
    }

}