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

//echo \app\widgets\ModularModal::widget();
?>

<div class="workstation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'brand_id', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['brand/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Brand hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Brand::find()->all(), 'id', 'name'),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki a Brandet...']
            ) ?>

            <?= $form->field($model, 'cpu_id', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['cpu/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új CPU hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Cpu::find()->all(), 'id', fn($cpu) => "{$cpu->brand} {$cpu->model}"),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki a CPU-t...']
            ) ?>
        </div>

        <div class="col-lg-4 mb-3">
            <?= $form->field($model, 'ram')->textInput()->label("RAM") ?>

            <?= $form->field($model, 'os')->textInput(['maxlength' => true])->label("OS") ?>

            <?= $form->field($model, 'colleague_id', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['colleague/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Kolléga hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Colleague::find()->all(), 'id', 'name'),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki a Kollégát...']
            ) ?>
        </div>

        <div class="col-lg-4 mb-3">
            <?= $form->field($model, 'office_id', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['office/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Iroda hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Office::find()->all(), 'id', 'name'),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki az Irodát...']
            ) ?>

            <?= $form->field($model, 'monitor_id1', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['monitor/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Monitor hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Monitor::find()->all(), 'id', fn($m) => "{$m->brand} {$m->model} S/N: {$m->s_n}"),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki az 1. Monitort...']
            ) ?>

            <?= $form->field($model, 'monitor_id2', [
                'template' => '<label class="form-label">{label}</label>
                           <div class="d-flex align-items-center gap-2">
                               {input}
                               ' . Html::a('+', ['monitor/create'], [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'universal-modal',
                        'title' => 'Új Monitor hozzáadása',
                    ]) . '
                               {error}
                           </div>',
            ])->dropDownList(
                ArrayHelper::map(Monitor::find()->all(), 'id', fn($m) => "{$m->brand} {$m->model} S/N: {$m->s_n}"),
                ['class' => 'form-control', 'prompt' => 'Válaszd ki a 2. Monitort...']
            ) ?>
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
