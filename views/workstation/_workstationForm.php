<?php

use app\controllers\MaintenanceController;
use app\widgets\ModularModal;
use yii\data\ActiveDataProvider;
use yii\debug\controllers\UserController;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Brand;
use app\models\Colleague;
use app\models\Cpu;
use app\models\Monitor;
use app\models\Office;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */
/** @var yii\widgets\ActiveForm $form */
/** @var ActiveDataProvider $maintenanceProvider */

echo ModularModal::widget();
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <?= $form->field($model, 'uploaded_by')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
            <?= $form->field($model, 'upload_date')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?>


            <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <label class="form-label" for="workstation-brand_id">Brand</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'brand_id',
                        ArrayHelper::map(Brand::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a Brandet...']
                    ) ?>
                    <?= Html::a('+', ['brand/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Brand hozzáadása',
                    ]) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="workstation-cpu_id">CPU</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'cpu_id',
                        ArrayHelper::map(
                            Cpu::find()->all(),
                            'id',
                            function ($cpu) {
                                return "{$cpu->brand} {$cpu->model}";
                            }
                        ),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a CPU-t...']
                    ) ?>
                    <?= Html::a('+', ['cpu/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új CPU hozzáadása',
                    ]) ?>
                </div>
            </div>

        </div>
        <div class="col-lg-4 mb-3">
            <div class="form-group">
                <?= $form->field($model, 'ram')->textInput()->label("RAM") ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'os')->textInput(['maxlength' => true])->label("OS") ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="workstation-brand_id">Kolléga</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'colleague_id',
                        ArrayHelper::map(Colleague::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a Kollégát...']
                    ) ?>
                    <?= Html::a('+', ['colleague/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Kolléga hozzáadása',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="workstation-brand_id">Iroda</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'office_id',
                        ArrayHelper::map(Office::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki az Irodát...']
                    ) ?>
                    <?= Html::a('+', ['office/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Kolléga hozzáadása',
                    ]) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="workstation-monitor_id1">1. Monitor</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'monitor_id1',
                        ArrayHelper::map(
                            Monitor::find()->all(),
                            'id',
                            function ($monitor) {
                                return "{$monitor->brand} {$monitor->model} (S/N: {$monitor->s_n})";
                            }
                        ),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a Monitort...']
                    ) ?>
                    <?= Html::a('+', ['monitor/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Monitor hozzáadása',
                    ]) ?>
                </div>
            </div>


            <div class="form-group">
                <label class="form-label" for="workstation-monitor_id1">2. Monitor</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'monitor_id2',
                        ArrayHelper::map(
                            Monitor::find()->all(),
                            'id',
                            function ($monitor) {
                                return "{$monitor->brand} {$monitor->model} (S/N: {$monitor->s_n})";
                            }
                        ),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a Monitort...']
                    ) ?>
                    <?= Html::a('+', ['monitor/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Monitor hozzáadása',
                    ]) ?>
                </div>
            </div>

        </div>


        <?= $form->field($model, 'anydesk_code')->textInput(['maxlength' => true])->label("AnyDesk Kód") ?>

        <?= $form->field($model, 'ms_office_license')->textInput(['maxlength' => true])->label("Office Licensz kulcs") ?>

        <?= $form->field($model, 'software_list')->textarea(['rows' => 3])->label("Szoftverek listája") ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 3])->label("Egyéb leírás") ?>

        <?php
        if ($model->getId()) {
        ?>
        <p>Feltöltötte: <?= \app\controllers\UserController::getUser($model->uploaded_by) ?></p>

        <?php
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton('Beküldés', ['class' => 'btn btn-success']) ?>
            <?php
            if (Yii::$app->request->get('id')) {
                echo Html::a(
                    'Munkaállomás törlése',
                    ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Biztosan törlöd ezt a munkaállomást?',
                            'method' => 'post',
                        ],
                    ]
                );
            }
            ?>
        </div>

        <?php
            if (Yii::$app->request->get('id')) {
                ?>
                <h2>Karbantartások</h2>



                <?= GridView::widget([
                    'dataProvider' => MaintenanceController::getMaintenancesForWorkstationIdAsProvider($model->getId()),
                    'columns' => [
                        [
                            'label' => 'Feltöltötte',
                            'value' => fn($model) => \app\controllers\UserController::getUser($model->uploaded_by)->username ?? '-',
                        ],
                        [
                            'label' => 'Dátum',
                            'value' => fn($model) => $model->date ?? '-',
                        ],
                        [
                            'label' => 'Hardware',
                            'format' => 'raw',
                            'value' => function($model) {
                                if ($model->hardware == 1) {
                                    return "<i class=\"bi bi-check-lg\"></i>";
                                }
                                return "<i class=\"bi bi-x\"></i>";
                            },
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Software',
                            'format' => 'raw',
                            'value' => function($model) {
                                if ($model->software == 1) {
                                    return "<i class=\"bi bi-check-lg\"></i>";
                                }
                                return "<i class=\"bi bi-x\"></i>";
                            },
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Leírás',
                            'value' => fn($model) => $model->description ?? '-',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="bi bi-pencil-square"></i>', ['maintenance/update', 'id' => $model->id],
                                        [
                                            'class' => 'btn btn-sm btn-outline-primary',
                                            'title' => 'Módosítás',
                                            'data' => [
                                                'method' => 'post',
                                                'pjax' => '1',
                                            ],
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>



        <?php
            }

        ?>




        <?php ActiveForm::end(); ?>

    </div>