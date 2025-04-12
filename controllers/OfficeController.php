<?php

namespace app\controllers;

use Yii;
use app\models\Office;
use yii\web\Controller;

class OfficeController extends Controller
{
    public function actionCreate()
    {
        $model = new Office();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_officeForm', ['model' => $model]);
    }
}
