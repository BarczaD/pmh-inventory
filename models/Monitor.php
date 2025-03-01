<?php

namespace app\models;

use yii\base\Model;

class Monitor extends Model
{
    public int $id;
    public string $brand;
    public string $aspectRatio;
    public string $serialNumber;
}