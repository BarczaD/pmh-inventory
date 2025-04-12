<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\Brand */
?>

<?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Brand neve') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
