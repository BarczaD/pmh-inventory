<?php

use app\controllers\WorkstationController;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="maintenance-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="form-group">
                <label class="form-label" for="maintenance-workstation_id">Munkaállomás Hostname</label>
                <?= Html::activeDropDownList(
                    $model,
                    'workstation_id',
                    ArrayHelper::map(WorkstationController::getWorkstations()->all(), 'id', 'hostname'),
                    ['class' => 'form-control', 'prompt' => 'Válaszd ki a Munkaállomást...']
                ) ?>
            </div>
        </div>
        <div class="col-lg-6 mb-5">
            <div class="form-group">
                <?= $form->field($model, 'hardware')->checkbox([
                    'uncheck' => 0,
                    'label' => 'Hardware',
                ]) ?>
                <?= $form->field($model, 'software')->checkbox([
                    'uncheck' => 0,
                    'label' => 'Software',
                ]) ?>
            </div>
        </div>

        <?= $form->field($model, 'date', [
            'options' => ['class' => 'col-lg-4 mb-5']
        ])->textInput(['type' => 'date'])->label('Dátum:') ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 3])->label("Egyéb leírás") ?>

        <div class="form-group">
            <?= Html::submitButton('Beküldés', ['class' => 'btn btn-success']) ?>
            <?= Html::a(
                'Karbantartás törlése',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Biztosan törlöd ezt a karbantartást?',
                        'method' => 'post',
                    ],
                ]
            ); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>