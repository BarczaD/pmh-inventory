<?php

namespace app\controllers;

use app\models\Maintenance;
use Yii;
use yii\data\ActiveDataProvider;
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

        $model->uploaded_by = Yii::$app->user->id;
        date_default_timezone_set('Europe/Budapest');
        $model->upload_date = date("Y-m-d h:i:s");
        var_dump($model);;
        exit();
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

    public function actionUpdate($id)
    {
        $model = Maintenance::findIdentity($id);

        if (!$model) {
            Yii::$app->session->setFlash('error', 'Karbantartás nem található.');
            return $this->redirect(["site/manage-data"]);
        }

        $post = Yii::$app->request->post();
        if ($post && $model->load($post)) {
            $model->processPost($post);
            $model->saveMaintenance();
            Yii::$app->session->setFlash('success', 'Karbantartás sikeresen frissítve.');
            return $this->redirect(["site/manage-data"]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    public function actionDelete($id)
    {
        $model = Maintenance::findOne($id);

        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'A karbantartás sikeresen törölve.');
        } else {
            Yii::$app->session->setFlash('error', 'A karbantartás nem található.');
        }

        return $this->redirect(['site/manage-data']);
    }

    public static function getMaintenancesForWorkstationIdAsProvider($id)
    {
        return new ActiveDataProvider([
        'query' => Maintenance::getMaintenancesOfWorkstation($id),
        'pagination' => [],
        'sort' => ["defaultOrder" => ["id" => SORT_DESC]],
    ]);
    }
}