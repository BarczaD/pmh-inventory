<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Workstation $model */

$this->title = 'New Workstation';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-new-workstation">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@app/views/workstation/_workstationForm', [
        'model' => $model,
    ]) ?>
</div>
