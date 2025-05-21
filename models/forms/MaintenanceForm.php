<?php

namespace app\models\forms;

use yii\base\Model;

class MaintenanceForm extends Model
{
    public $date;
    public $workstation_id;
    public $hardware;
    public $software;
    public $description;

    public function rules()
    {
        return [
            [['date', 'workstation_id', 'hardware', 'software'], 'required'],
        ];
    }

    public function saveMaintenance()
    {

    }

}