<?php
namespace app\models;

use app\models\Brand;
use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Office;
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
            [['software_list', 'description'], 'string'],
            [['ms_office_license'], 'string'],
            [['hostname', 'os'], 'string', 'max' => 255],
        ];
    }

    public function getColleague()
    {
        return $this->hasOne(Colleague::class, ['id' => 'colleague_id']);
    }

    public function getOffice()
    {
        return $this->hasOne(Office::class, ['id' => 'office_id']);
    }

    public function getMonitor1()
    {
        return $this->hasOne(Monitor::class, ['id' => 'monitor_id1']);
    }

    public function getMonitor2()
    {
        return $this->hasOne(Monitor::class, ['id' => 'monitor_id2']);
    }

    public function getCpu()
    {
        return $this->hasOne(Cpu::class, ['id' => 'cpu_id']);
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
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