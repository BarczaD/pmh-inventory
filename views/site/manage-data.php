<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\ModularModal;
use yii\widgets\Pjax;

/** @var yii\data\ActiveDataProvider $workstationProvider */
/** @var yii\data\ActiveDataProvider $cpuProvider */

echo ModularModal::widget();

$this->title = 'Adatok Kezelése';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Adatok kezelése</h1>

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $cpuProvider,
                    'columns' => [
                        [
                            'label' => 'Brand',
                            'value' => fn($model) => $model->brand->name ?? '-',
                        ],
                        [
                            'label' => 'Modell',
                            'value' => fn($model) => $model->model->name ?? '-',
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
            </div>
        </div>
    </div>

    <div class="body-content">

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $workstationProvider,
            'columns' => [
                'hostname',
                [
                    'label' => 'Hostname',
                    'value' => fn($model) => $model->hostname->name ?? '-',
                ],
                [
                    'label' => 'Brand',
                    'value' => fn($model) => $model->brand->name ?? '-',
                ],
                [
                    'label' => 'CPU',
                    'value' => fn($model) => $model->cpu->model ?? '-',
                ],
                [
                    'label' => 'RAM',
                    'value' => fn($model) => $model->ram->model ?? '-',
                ],
                [
                    'label' => 'OS',
                    'value' => fn($model) => $model->os->model ?? '-',
                ],
                [
                    'label' => 'Kolléga',
                    'value' => fn($model) => $model->colleague->name ?? '-',
                ],
                [
                    'label' => 'Iroda',
                    'value' => fn($model) => $model->office->name ?? '-',
                ],
                [
                    'label' => 'Monitor1',
                    'value' => fn($model) => $model->monitor1->model ?? '-',
                ],
                [
                    'label' => 'Monitor2',
                    'value' => fn($model) => $model->monitor2->model ?? '-',
                ],
                [
                    'label' => 'Leírás',
                    'value' => fn($model) => $model->description->model ?? '-',
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>


        <?php
        echo Html::a('Iroda hozzáadása gomb', ['office/create'], [
            'class' => 'btn btn-primary',
            'data-toggle' => 'universal-modal',
        ]);
        echo Html::a('CPU hozzáadása gomb', ['cpu/create'], [
            'class' => 'btn btn-primary',
            'data-toggle' => 'universal-modal',
        ]);
        echo Html::a('Monitor hozzáadása gomb', ['monitor/create'], [
            'class' => 'btn btn-primary',
            'data-toggle' => 'universal-modal',
        ]);
        echo Html::a('Brand hozzáadása gomb', ['brand/create'], [
            'class' => 'btn btn-primary',
            'data-toggle' => 'universal-modal',
        ]);
        echo Html::a('Kolléga hozzáadása gomb', ['colleague/create'], [
            'class' => 'btn btn-primary',
            'data-toggle' => 'universal-modal',
        ]);

        ?>

    </div>
</div>
