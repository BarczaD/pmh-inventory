<?php

/** @var yii\web\View $this */

use app\models\Monitor;
use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\ModularModal;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\data\ActiveDataProvider $workstationProvider */
/** @var yii\data\ActiveDataProvider $cpuProvider */
/** @var \yii\data\ActiveDataProvider $monitorProvider */
/** @var \yii\data\ActiveDataProvider $officeProvider */
/** @var \yii\data\ActiveDataProvider $colleagueProvider */
/** @var \yii\data\ActiveDataProvider $brandProvider */
/** @var string|null $searchHostname */
/** @var string|null $searchColleague */
/** @var string|null $searchOffice */
/** @var string $alert */

echo ModularModal::widget();

$this->title = 'Felhasználók kezelése';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-5"><?= $this->title ?></h1>
    </div>

    <div class="body-content">

        <?php Pjax::begin(); ?>

        <div class="workstation-search mb-3">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['manage-users'],
            ]); ?>

            <div class="row">
                <div class="col-md-3">
                    <?= Html::textInput('hostname', $searchHostname, ['class' => 'form-control', 'placeholder' => 'Hostname']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::textInput('searchColleague', $searchColleague, ['class' => 'form-control', 'placeholder' => 'Kolléga neve']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::textInput('searchOffice', $searchOffice, ['class' => 'form-control', 'placeholder' => 'Iroda']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::submitButton('Keresés', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Alaphelyzet', ['manage-data'], ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
