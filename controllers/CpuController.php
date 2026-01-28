<?php

namespace app\controllers;

use Yii;
use app\models\Cpu;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
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
            try {
                $success = Yii::$app->db->transaction(function() use ($model) {
                    return $model->save();
                });

                if ($success) {
                    Yii::$app->session->setFlash('success', "Processzor rögzítve: <b>{$model->brand} {$model->model}</b>");
                    return 'success';
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', "Hiba a mentés során: " . $e->getMessage());
            }
        }

        return $this->renderAjax('_cpuForm', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $cpuName = "{$model->brand} {$model->model}";

        try {
            Yii::$app->db->transaction(function() use ($model) {
                if (!$model->delete()) {
                    throw new \Exception('Az adatbázis elutasította a törlést.');
                }
            });
            Yii::$app->session->setFlash('success', "Processzor és naplóbejegyzés törölve: <b>$cpuName</b>");
        } catch (\Exception $e) {
            // This usually catches Foreign Key constraints (e.g. CPU is used in a Workstation)
            Yii::$app->session->setFlash('error', "Nem törölhető: $cpuName. Valószínűleg már hozzá van rendelve egy géphez.");
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['site/manage-data']);
    }

    protected function findModel($id)
    {
        if (($model = Cpu::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A keresett CPU nem található.');
    }

    public function actionIndex()
    {
        $cpuProvider = new ActiveDataProvider([
            'query' => Cpu::find(),
            'pagination' => ['pageSize' => 20],
            'sort' => [
                'defaultOrder' => ['brand' => SORT_ASC, 'model' => SORT_ASC]
            ],
        ]);

        return $this->render('index', [
            'cpuProvider' => $cpuProvider,
        ]);
    }
}