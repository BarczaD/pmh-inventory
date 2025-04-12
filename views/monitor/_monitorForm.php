<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\Monitor */
?>

<?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>

<?= $form->field($model, 'brand')->textInput(['maxlength' => true])->label('Márka') ?>
<?= $form->field($model, 'model')->textInput(['maxlength' => true])->label('Modell') ?>
<?= $form->field($model, 's_n')->textInput(['maxlength' => true])->label('Sorozatszám') ?>
<?= $form->field($model, 'i_n')->textInput(['maxlength' => true])->label('Leltári szám') ?>
<?= $form->field($model, 'description')->textarea(['rows' => 4])->label('Leírás') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
