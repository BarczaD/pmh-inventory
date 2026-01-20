<?php

namespace app\controllers;

use app\models\Log;
use Yii;
use yii\web\Controller;

class LogController extends Controller
{
    const INFO = 1;
    const ALERT = 2;
    const WARNING = 3;
    const ERROR = 4;

    public function actionCreate()
    {
    }

    public static function logThis(int $event_type, string $event_description)
    {
        $log = new Log();
        $log->log_date = date("Y-m-d H:i:s");
        $log->event_type = $event_type;
        $log->event_description = $event_description;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $log->save();
            $transaction->commit();
        } catch (\Exception $exception) {

        }
    }

    public static function getLogs()
    {
        return Log::getLogs();
    }

    public function actionDelete($id) {
        try {
            if (Log::deleteLog($id)) {
                Yii::$app->session->setFlash('success', 'Log sikeresen törölve.');
            } else {
                Yii::$app->session->setFlash('error', 'Log nem található.');
            }
        } catch (\Throwable $th) {
            Yii::$app->session->setFlash('error', 'A Log törlése közben hiba lépett fel:<br>' . $th->getMessage());
        }

        $this->redirect(["site/manage-data"]);
    }
}