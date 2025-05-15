<?php

namespace app\controllers;

use Yii;
use app\models\Brand;
use yii\web\Controller;

class BrandController extends Controller
{
    public static function getBrands()
    {
        return Brand::getBrands();
    }

    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_brandForm', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        try {
            if (Brand::deleteBrand($id)) {
                Yii::$app->session->setFlash('success', 'Brand sikeresen törölve.');
            } else {
                Yii::$app->session->setFlash('error', 'CPU nem található.');
            }
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('error', 'A brand törlése közben hiba lépett fel:<br>' . $th->getMessage());
        }

        $this->redirect(["site/manage-data"]);
    }
}