<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\models\Cpu */
?>

<?php $form = ActiveForm::begin([
    'id' => 'modal-form',
]); ?>

<?= $form->field($model, 'brand')->textInput()->label('')->label('Márka') ?>
<?= $form->field($model, 'model')->textInput()->label('')->label('Modell') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
