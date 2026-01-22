<?php

namespace app\controllers;

use app\models\Log;
use app\models\Maintenance;
use app\models\Workstation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\db\QueryInterface;
use yii\web\NotFoundHttpException;

class WorkstationController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Workstation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Munkaállomás ({$model->hostname}) sikeresen létrehozva.");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public static function getWorkstations()
    {
        return Workstation::find()->with(['brand', 'colleague', 'cpu', 'monitor', 'office']);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Munkaállomás sikeresen frissítve.');
            return $this->redirect(['site/manage-data']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Workstation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Workstation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workstation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A keresett munkaállomás nem található.');
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        LogController::logThis();
        // 2. (Optional) Log the event before deleting, since you have a Log system now
        // Yii::info("Workstation {$model->hostname} deleted by " . Yii::$app->user->identity->username, 'audit');
        $model->delete();

        Yii::$app->session->setFlash('success', 'A munkaállomás sikeresen törölve.');

        return $this->redirect(['site/manage-data']);
    }


    public function actionNetworkStatus()
    {
        /*
        $models = Workstation::find()->select(['hostname'])->all();

        $online = 0;
        $offline = 0;

        foreach ($models as $model) {
            $host = escapeshellarg($model->hostname);

            exec("ping -n 1 -w 500 $host", $output, $result);

            if ($result === 0) {
                $online++;
            } else {
                $offline++;
            }
        }

        return $this->render('network-status', [
            'online' => $online,
            'offline' => $offline,
        ]);
        */
        //TODO
    }
}