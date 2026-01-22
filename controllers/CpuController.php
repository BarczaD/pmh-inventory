<?php

namespace app\controllers;

use Yii;
use app\models\Cpu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class CpuController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // Security: prevent deletion via URL
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Cpu();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                // If it's an AJAX request (modal), return success state
                return 'success';
            }
        }

        // renderAjax is perfect for modals
        return $this->renderAjax('_cpuForm', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'CPU sikeresen törölve.');
        } else {
            Yii::$app->session->setFlash('error', 'Hiba történt a törlés során.');
        }

        return $this->redirect(["site/manage-data"]);
    }

    protected function findModel($id)
    {
        if (($model = Cpu::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A kért CPU nem található.');
    }
}