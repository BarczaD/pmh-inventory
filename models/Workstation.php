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
            [['brand_id', 'cpu_id', 'colleague_id', 'office_id', 'monitor_id1', 'monitor_id2'], 'integer'],
            [['software_list', 'description', 'anydesk_code'], 'string'],
            [['ms_office_license'], 'string'],
            [['hostname', 'os'], 'string', 'max' => 255],
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

    public function processPost($post)
    {
        try {
            $post = $post['Workstation'];

            $this->hostname = $post['hostname'];
            $this->brand_id = intval($post['brand_id']);
            $this->cpu_id = intval($post['cpu_id']);
            $this->ram = intval($post['ram']);
            $this->os = $post['os'];
            $this->colleague_id = intval($post['colleague_id']);
            $this->monitor_id1 = $post['monitor_id1'] != "" ? intval($post['monitor_id1']) : null;
            $this->monitor_id2 = $post['monitor_id2'] != "" ? intval($post['monitor_id2']) : null;
            $this->ms_office_license = $post['ms_office_license'];
            $this->software_list = $post['software_list'];
            $this->description = $post['description'] != "" ? $post['description'] : null;

            return true;
        } catch (\Exception $ex) {
            echo($ex->getMessage());
            return false;
        }
    }

}