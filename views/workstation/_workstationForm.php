<?php

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

echo \app\widgets\ModularModal::widget();
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 mb-3">
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
                <label class="form-label" for="workstation-brand_id">CPU</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'cpu_id',
                        ArrayHelper::map(Cpu::find()->all(), 'id', 'name'),
                        ['class' => 'form-control', 'prompt' => 'Válaszd ki a CPU-t...']
                    ) ?>
                    <?=
                    Html::a('+', ['cpu/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                    ])?>
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
                <label class="form-label" for="workstation-brand_id">1. Monitor</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'monitor_id1',
                        ArrayHelper::map(Monitor::find()->all(), 'id', 'name'),
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
                <label class="form-label" for="workstation-brand_id">2. Monitor</label>
                <div class="d-flex align-items-center gap-2">
                    <?= Html::activeDropDownList(
                        $model,
                        'monitor_id2',
                        ArrayHelper::map(Monitor::find()->all(), 'id', 'name'),
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


    <?= $form->field($model, 'ms_office_license')->textInput(['maxlength' => true])->label("Office Licensz kulcs") ?>

    <?= $form->field($model, 'software_list')->textarea(['rows' => 3])->label("Szoftverek listája") ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3])->label("Egyéb leírás") ?>

    <div class="form-group">
        <?= Html::submitButton('Beküldés', ['class' => 'btn btn-success']) ?>
    </div>




    <?php ActiveForm::end(); ?>

</div>
