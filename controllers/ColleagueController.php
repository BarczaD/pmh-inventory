<?php

namespace app\controllers;

use Yii;
use app\models\Colleague;
use yii\web\Controller;

class ColleagueController extends Controller
{
    public function actionCreate()
    {
        $model = new Colleague();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_colleagueForm', ['model' => $model]);
    }

}