<?php

namespace app\controllers;

use Yii;
use app\models\Cpu;
use yii\web\Controller;

class CpuController extends Controller
{
    public function actionCreate()
    {
        $model = new Cpu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';

        }

        return $this->renderAjax('_cpuForm', ['model' => $model]);
    }

    public static function getCpus()
    {
        return Cpu::getCpus();
    }

    public function actionDelete($id)
    {
        return Cpu::deleteCpu($id);
    }
}