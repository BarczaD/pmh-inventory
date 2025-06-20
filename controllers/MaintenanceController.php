<?php

namespace app\controllers;

use app\models\Maintenance;
use Yii;
use yii\web\Controller;

class MaintenanceController extends Controller
{
    public static function getMaintenances()
    {
        return Maintenance::getMaintenances();
    }

    public static function processNewMaintenance($post) {

        $model = new Maintenance();
        if (!$model->processPost($post)) {
            return false;
        }

        return $model->saveMaintenance();
    }

    public function actionCreate()
    {
        $model = new Maintenance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('new-maintenance', [
            'model' => $model,
        ]);
    }
}