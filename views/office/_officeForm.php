<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\Office */
?>

<?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Iroda helye/neve') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
