<?php

namespace app\controllers;

use Yii;
use app\models\Monitor;
use yii\web\Controller;

class MonitorController extends Controller
{
    public function actionCreate()
    {
        $model = new Monitor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_monitorForm', ['model' => $model]);
    }

    public static function getMonitors()
    {
        return Monitor::getMonitors();
    }

}