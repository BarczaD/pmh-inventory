<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use Yii;

class Log extends ActiveRecord
{
    public static function tableName()
    {
        return 'log';
    }

    public static function getLogs()
    {
        return Log::find()->with();
    }

    public function rules()
    {
        return [
            [['log_date', 'alert_level', 'event_type', 'event_description', 'triggered_by'], 'required'],
            [['event_description'], 'string', 'max' => 255],
            [['alert_level', 'event_type', 'triggered_by'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'log_date',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Maps LogEvent constants to human-readable Hungarian labels.
     */
    public static function eventTypeLabels()
    {
        return [
            // CPU
            LogEvent::CPU_CREATE => 'CPU létrehozva',
            LogEvent::CPU_UPDATE => 'CPU módosítva',
            LogEvent::CPU_DELETE => 'CPU törölve',

            // Brand
            LogEvent::BRAND_CREATE => 'Márka létrehozva',
            LogEvent::BRAND_UPDATE => 'Márka módosítva',
            LogEvent::BRAND_DELETE => 'Márka törölve',

            // Kolléga
            LogEvent::COLLEAGUE_CREATE => 'Kolléga létrehozva',
            LogEvent::COLLEAGUE_UPDATE => 'Kolléga módosítva',
            LogEvent::COLLEAGUE_DELETE => 'Kolléga törölve',

            // Monitor
            LogEvent::MONITOR_CREATE => 'Monitor létrehozva',
            LogEvent::MONITOR_UPDATE => 'Monitor módosítva',
            LogEvent::MONITOR_DELETE => 'Monitor törölve',

            // Iroda
            LogEvent::OFFICE_CREATE => 'Iroda létrehozva',
            LogEvent::OFFICE_UPDATE => 'Iroda módosítva',
            LogEvent::OFFICE_DELETE => 'Iroda törölve',

            // Workstation
            LogEvent::WORKSTATION_CREATE => 'Gép létrehozva',
            LogEvent::WORKSTATION_UPDATE => 'Gép módosítva',
            LogEvent::WORKSTATION_DELETE => 'Gép törölve',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'triggered_by']);
    }

    public function getEventLabel()
    {
        $labels = self::eventTypeLabels();
        return $labels[$this->event_type] ?? "Ismeretlen esemény ({$this->event_type})";
    }

    public function getAlertBadge()
    {
        // Level 2 is Warning/Danger (Deletions), Level 1 is Info (Creations/Updates)
        if ($this->alert_level == 2) {
            return '<span class="badge bg-danger">Figyelmeztetés</span>';
        }
        return '<span class="badge bg-info">Információ</span>';
    }
}