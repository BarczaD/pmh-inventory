<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */

$this->title = 'Új Munkaállomás felvétele';
?>

<div class="site-new-workstation">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@app/views/workstation/_workstationForm', [
        'model' => $model,
    ]) ?>
</div>
