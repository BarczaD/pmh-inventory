<?php

namespace app\controllers;

use Yii;
use app\models\Office;
use yii\web\Controller;

class OfficeController extends Controller
{
    public static function getOffices()
    {
        return Office::find()->with();
    }

    public function actionCreate()
    {
        $model = new Office();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_officeForm', ['model' => $model]);
    }

    public function actionDelete($id) {
        try {
            if (Office::deleteOffice($id)) {
                Yii::$app->session->setFlash('success', 'Iroda sikeresen törölve.');
            } else {
                Yii::$app->session->setFlash('error', 'Iroda nem található.');
            }
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('error', 'Az iroda törlése közben hiba lépett fel:<br>' . $th->getMessage());
        }

        $this->redirect(["site/manage-data"]);
    }
}
