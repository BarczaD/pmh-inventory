<?php

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */

$this->title = 'Create Workstation';
$this->params['breadcrumbs'][] = ['label' => 'Workstations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workstation-create">

    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?= $this->render('_workstationForm', [
        'model' => $model,
    ]) ?>

</div>
