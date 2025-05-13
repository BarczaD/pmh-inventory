<?php

use app\models\Brand;
use app\models\Cpu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model */
?>
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Modify Workstation';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="workstation-update">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'brand_id')->dropDownList(
        ArrayHelper::map(Brand::find()->all(), 'id', 'name'),
        ['prompt' => 'Select a Brand']
    ) ?>
    <?= $form->field($model, 'cpu_id')->dropDownList(
        ArrayHelper::map(Cpu::find()->all(), 'id', 'model'),
        ['prompt' => 'Select a CPU']
    ) ?>
    <?= $form->field($model, 'ram')->textInput() ?>
    <?= $form->field($model, 'os')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
