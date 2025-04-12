<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\Colleague */
?>

<?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Név') ?>
<?= $form->field($model, 'department')->textInput(['maxlength' => true])->label('Iroda') ?>
<?= $form->field($model, 'group')->textInput(['maxlength' => true])->label('Csoport') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
