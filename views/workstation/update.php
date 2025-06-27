<?php

use yii\helpers\Html;

$this->title = 'Munkaállomás Módosítása';
/** @var $model */
/** @var $maintenanceProvider */
?>


<div class="workstation-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_workstationForm', [
        'model' => $model,
        'maintenanceProvider' => $maintenanceProvider,
    ]) ?>
</div>
