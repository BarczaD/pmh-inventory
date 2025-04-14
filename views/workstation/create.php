<?php

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */

use yii\helpers\Html;

$this->title = 'Munkaállomás hozzáadaása';
?>
<div class="workstation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_workstationForm', [
        'model' => $model,
    ]) ?>

</div>
