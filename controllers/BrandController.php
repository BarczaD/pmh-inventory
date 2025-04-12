<?php

namespace app\controllers;

use Yii;
use app\models\Brand;
use yii\web\Controller;

class BrandController extends Controller
{
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_brandForm', ['model' => $model]);
    }

}