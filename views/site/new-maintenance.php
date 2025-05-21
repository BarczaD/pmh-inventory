<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */

$this->title = 'Új Karbantartás felvétele';
?>

<div class="site-new-workstation">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@app/views/maintenance/_maintenanceForm', [
        'model' => $model,
    ]) ?>
</div>