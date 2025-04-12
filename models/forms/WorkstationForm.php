<?php

namespace app\models\forms;

use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use yii\base\Model;

class WorkstationForm extends Model
{
    public $hostname;
    public $brand;
    public Cpu $cpu;
    public $ram;
    public $os;
    public Colleague $colleague;
    public $office;
    public Monitor $monitor1;
    public Monitor $monitor2;
    public $msOfficeLicense;
    public $softwareList;
    public $description;
}