<?php

namespace app\controllers;

use app\models\Maintenance;

class MaintenanceController
{
    public static function getMaintenances()
    {
        return Maintenance::getMaintenances();
    }


}