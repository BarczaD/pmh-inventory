<?php

use app\controllers\WorkstationController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Brand;
use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Office;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="maintenance-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="form-group">
                <label class="form-label" for="maintenance-workstation_id">Munkaállomás</label>
                <?= Html::activeDropDownList(
                    $model,
                    'workstation_id',
                    ArrayHelper::map(WorkstationController::getWorkstations()->all(), 'id', 'hostname'),
                    ['class' => 'form-control', 'prompt' => 'Válaszd ki a Munkaállomást...']
                ) ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="maintenance-workstation_id">Munkaállomás</label>

            </div>
        </div>






        <?php ActiveForm::end(); ?>

    </div>