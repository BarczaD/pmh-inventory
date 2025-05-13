<?php

namespace app\controllers;

use app\models\Workstation;
use Yii;
use yii\web\Controller;
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

    public function actionUpdate($id)
    {
        $model = Workstation::findIdentity($id);

        if (!$model) {
            Yii::$app->session->setFlash('error', 'Munkaállomás nem található.');
            $this->redirect(["site/manage-data"]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Munkaállomás sikeresen frissítve.');
            $this->redirect(["site/manage-data"]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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