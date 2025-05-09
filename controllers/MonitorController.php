<?php

namespace app\controllers;

use Yii;
use app\models\Monitor;
use yii\db\QueryInterface;
use yii\web\Controller;

class MonitorController extends Controller implements QueryInterface
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

    public function actionDelete($id) {
        try {
            if (Monitor::deleteMonitor($id)) {
                Yii::$app->session->setFlash('success', 'Monitor sikeresen törölve.');
            } else {
                Yii::$app->session->setFlash('error', 'Monitor nem található.');
            }
        } catch (\Throwable $th) {
                Yii::$app->session->setFlash('error', 'A monitor törlése közben hiba lépett fel:<br>' . $th->getMessage());
        }

        $this->redirect(["site/manage-data"]);
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
}