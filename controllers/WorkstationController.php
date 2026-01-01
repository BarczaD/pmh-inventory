<?php

namespace app\controllers;

use app\models\Maintenance;
use app\models\Workstation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\db\QueryInterface;

class WorkstationController extends Controller implements QueryInterface
{
    public function actionCreate()
    {
        $model = new Workstation();

        if ($model->load(Yii::$app->request->post())) {
            $model->uploaded_by = Yii::$app->user->id;
            date_default_timezone_set('Europe/Budapest');
            $model->upload_date = date("Y-m-d h:i:s");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('new-workstation', [
            'model' => $model,
        ]);
    }

    public static function getWorkstations()
    {
        return Workstation::find()->with(['brand', 'colleague', 'cpu', 'monitor', 'office']);
    }

    public function actionUpdate($id)
    {
        $model = Workstation::findIdentity($id);

        if (!$model) {
            Yii::$app->session->setFlash('error', 'Munkaállomás nem található.');
            return $this->redirect(["site/manage-data"]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Munkaállomás sikeresen frissítve.');
            return $this->redirect(["site/manage-data"]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    public function actionDelete($id)
    {
        $model = Workstation::findOne($id);

        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'A munkaállomás sikeresen törölve.');
        } else {
            Yii::$app->session->setFlash('error', 'A munkaállomás nem található.');
        }

        return $this->redirect(['site/manage-data']);
    }



    public function all($db = null)
    {
        // TODO: Implement all() method.
    }

    public function one($db = null)
    {
        // TODO: Implement one() method.
    }

    public function count($q = '*', $db = null)
    {
        // TODO: Implement count() method.
    }

    public function exists($db = null)
    {
        // TODO: Implement exists() method.
    }

    public function indexBy($column)
    {
        // TODO: Implement indexBy() method.
    }

    public function where($condition)
    {
        // TODO: Implement where() method.
    }

    public function andWhere($condition)
    {
        // TODO: Implement andWhere() method.
    }

    public function orWhere($condition)
    {
        // TODO: Implement orWhere() method.
    }

    public function filterWhere(array $condition)
    {
        // TODO: Implement filterWhere() method.
    }

    public function andFilterWhere(array $condition)
    {
        // TODO: Implement andFilterWhere() method.
    }

    public function orFilterWhere(array $condition)
    {
        // TODO: Implement orFilterWhere() method.
    }

    public function orderBy($columns)
    {
        // TODO: Implement orderBy() method.
    }

    public function addOrderBy($columns)
    {
        // TODO: Implement addOrderBy() method.
    }

    public function limit($limit)
    {
        // TODO: Implement limit() method.
    }

    public function offset($offset)
    {
        // TODO: Implement offset() method.
    }

    public function emulateExecution($value = true)
    {
        // TODO: Implement emulateExecution() method.
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