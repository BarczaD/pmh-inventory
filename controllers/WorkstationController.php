<?php

namespace app\controllers;

use app\models\Workstation;
use Yii;
use yii\base\Controller;
use yii\db\QueryInterface;

class WorkstationController extends Controller implements QueryInterface
{
    public function actionCreate()
    {
        $model = new Workstation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

    public function registerWorkstation()
    {
        /* DEPRECATED
        $workstation = new Workstation();
        $workstation->hostname = Yii::$app->request->post('hostname');
        $workstation->brandId  = Brand::findByName(Yii::$app->request->post('brand'))->getId();
        var_dump(Brand::findByName(Yii::$app->request->post('brand')));
        $workstation->cpuId = Cpu::findByModel(Yii::$app->request->post('cpu'))->getId();
        var_dump(Cpu::findByModel(Yii::$app->request->post('cpu')));
        $workstation->ram = Yii::$app->request->post('ram');
        $workstation->os = Yii::$app->request->post('os');
        $workstation->colleagueId = Colleague::findByName(Yii::$app->request->post('colleague'))->getId();
        var_dump(Colleague::findByName(Yii::$app->request->post('colleague')));
        $workstation->officeId = Office::findByName(Yii::$app->request->post('office'))->getId();
        var_dump(Office::findByName(Yii::$app->request->post('office')));
        $workstation->monitorId1 = Monitor::findMonitorBySerial(explode(Yii::$app->request->post('monitor_id1'), 'S\N:')[1])->getId();

        if (Yii::$app->request->post('monitor_id2'))
        {
            $workstation->monitorId2 = Monitor::findMonitorBySerial(explode(Yii::$app->request->post('monitor_id2'), 'S\N:')[1])->getId();
        } else
        {
            $workstation->monitorId2 = null;
        }

        $workstation->msOfficeLicense = Yii::$app->request->post('ms_office_license');
        $workstation->softwareList = Yii::$app->request->post('software_list');
        $workstation->description = Yii::$app->request->post('description');

        $workstation->saveWorkstation();
        */
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