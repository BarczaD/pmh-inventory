<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var app\models\PasswordChangeForm $model */

$this->title = 'Jelszó megváltoztatása';
?>

<div class="user-password-change">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'confirm_password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Jelszó frissítése', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>