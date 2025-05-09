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

    public function actionDelete($id) {
        try {
            if (Cpu::deleteCpu($id)) {
                Yii::$app->session->setFlash('success', 'CPU sikeresen törölve.');
            } else {
                Yii::$app->session->setFlash('error', 'CPU nem található.');
            }
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('error', 'A CPU törlése közben hiba lépett fel:<br>' . $th->getMessage());
        }

        $this->redirect(["site/manage-data"]);
    }
}