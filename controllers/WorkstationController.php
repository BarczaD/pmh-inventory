<?php

namespace app\controllers;

use app\models\Workstation;
use Yii;
use yii\base\Controller;

class WorkstationController extends Controller
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

}