<?php
namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Cpu extends ActiveRecord
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
            [['brand', 'model'], 'trim'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $log = new \app\models\Log();
        $log->alert_level = 1;
        $log->event_type = $insert ? LogEvent::CPU_CREATE : LogEvent::CPU_UPDATE;
        $log->event_description = ($insert ? "Új CPU: " : "CPU módosítva: ") . "{$this->brand} {$this->model}";
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
        $log->event_type = LogEvent::CPU_DELETE;
        $log->event_description = "CPU törölve: {$this->brand} {$this->model}";
        $log->triggered_by = Yii::$app->user->id ?? 0;

        if (!$log->save()) {
            throw new \yii\db\Exception("CPU Törlés naplózási hiba.");
        }
    }

    /**
     * Automate metadata. This replaces registerCpu() and manual controller logic.
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->uploaded_by = Yii::$app->user->id;
            $this->upload_date = date("Y-m-d H:i:s");
        }

        return true;
    }

    public static function find(): ActiveQuery
    {
        return parent::find();
    }

    private static $_list;
    public static function getList(): array
    {
        if (self::$_list === null) {
            $data = self::find()
                ->select(['id', 'brand', 'model'])
                ->asArray()
                ->all();
            self::$_list = ArrayHelper::map($data, 'id', function ($item) {
                return $item['brand'] . ' ' . $item['model'];
            });
        }
        return self::$_list;
    }
}