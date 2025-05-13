<?php

use yii\helpers\Html;

$this->title = 'Munkaállomás Módosítása';
/** @var $model */
?>


<div class="workstation-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_workstationForm', [
        'model' => $model,
    ]) ?>
</div>
