<?php

namespace app\models;

class Log
{
    public static function tableName()
    {
        return 'log';
    }

    public function rules()
    {
        return [
            [['log_date', 'alert_level', 'event_type', 'event_description', 'triggered_by'], 'required'],
            [['event_description'], 'string', 'max' => 255],
            [['log_date', 'alert_level', 'event_type', 'triggered_by'], 'integer'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $log = new Log();
        $log->event_type = $insert ? LogEvent::COLLEAGUE_CREATE : LogEvent::COLLEAGUE_UPDATE;
        $log->triggered_by = Yii::$app->user->id;
        $log->event_description = "Név: {$this->name} (ID: {$this->id})";
        $log->save(false);
    }
}