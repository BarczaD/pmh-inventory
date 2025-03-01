<?php

namespace app\models;

use yii\base\Model;

class Computer extends Model
{
    public int $id;
    public Colleague $colleague;
    public string $dnsName;
    public string $office;
    public string $cpu;
    public string $ram;
    public string $storageType;
    public string $storageCapacity;
    public Monitor $monitor1;
    public Monitor $monitor2;
    public string $keyboard;
    public string $mouse;
    public string $officeLicense;
}