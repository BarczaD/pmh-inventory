<?php

namespace app\models\forms;

use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Workstation;
use Yii;
use yii\base\Model;

class WorkstationForm extends Model
{
    public $hostname;
    public $brand_id;
    public $cpu_id;
    public $ram;
    public $os;
    public $colleague_id;
    public $office_id;
    public $monitor_id1;
    public $monitor_id2;
    public $anydesk_code;
    public $ms_office_license;
    public $software_list;
    public $description;
}