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
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_id')->dropDownList(
        ArrayHelper::map(Brand::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Brand']
    ) ?>

    <?= $form->field($model, 'cpu_id')->dropDownList(
        ArrayHelper::map(Cpu::find()->all(), 'id', fn($cpu) => "{$cpu->brand} {$cpu->model}"),
        ['prompt' => 'Select CPU']
    ) ?>

    <?= $form->field($model, 'ram')->textInput() ?>

    <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'colleague_id')->dropDownList(
        ArrayHelper::map(Colleague::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Colleague']
    ) ?>

    <?= $form->field($model, 'office_id')->dropDownList(
        ArrayHelper::map(Office::find()->all(), 'id', 'name'),
        ['prompt' => 'Select Office']
    ) ?>

    <?= $form->field($model, 'monitor_id1')->dropDownList(
        ArrayHelper::map(Monitor::find()->all(), 'id', fn($m) => "{$m->brand} {$m->model} ({$m->s_n})"),
        ['prompt' => 'Select Monitor 1']
    ) ?>

    <?= $form->field($model, 'monitor_id2')->dropDownList(
        ArrayHelper::map(Monitor::find()->all(), 'id', fn($m) => "{$m->brand} {$m->model} ({$m->s_n})"),
        ['prompt' => 'Select Monitor 2']
    ) ?>

    <?= $form->field($model, 'ms_office_license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'software_list')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
