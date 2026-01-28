<?php

namespace app\controllers;

use Yii;
use app\models\Brand;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BrandController extends Controller
{
    public static function getBrands()
    {
        return Brand::getBrands();
    }

    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post())) {
            try {
                // Transaction handles both the Brand save AND the Log save inside afterSave()
                $success = Yii::$app->db->transaction(function() use ($model) {
                    return $model->save();
                });

                if ($success) {
                    Yii::$app->session->setFlash('success', "Sikeres mentés.");
                    return 'success';
                }
            } catch (\Exception $e) {
                // If the log fails or the brand fails, we end up here
                Yii::$app->session->setFlash('error', "Hiba: " . $e->getMessage());
            }
        }

        return $this->renderAjax('_brandForm', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            Yii::$app->db->transaction(function() use ($model) {
                if (!$model->delete()) {
                    throw new \Exception('Nem törölhető.');
                }
            });
            Yii::$app->session->setFlash('success', "Brand törölve.");
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Sikertelen törlés: " . $e->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('A keresett Brand nem található.');
    }

    public function actionIndex()
    {
        $brandProvider = new ActiveDataProvider([
            'query' => Brand::find(),
            'pagination' => ['pageSize' => 20],
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
        ]);

        return $this->render('index', [
            'brandProvider' => $brandProvider,
        ]);
    }
}