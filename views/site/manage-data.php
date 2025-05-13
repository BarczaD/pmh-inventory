<?php

/** @var yii\web\View $this */

use app\models\Monitor;
use yii\grid\GridView;
use yii\helpers\Html;
use app\widgets\ModularModal;
use yii\widgets\Pjax;

/** @var yii\data\ActiveDataProvider $workstationProvider */
/** @var yii\data\ActiveDataProvider $cpuProvider */
/** @var \yii\data\ActiveDataProvider $monitorProvider */
/** @var \yii\data\ActiveDataProvider $officeProvider */
/** @var \yii\data\ActiveDataProvider $colleagueProvider */
/** @var string $alert */

echo ModularModal::widget();

$this->title = 'Adatok Kezelése';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Adatok kezelése</h1>


    </div>

    <div class="body-content">

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $workstationProvider,
            'columns' => [
                [
                    'label' => 'Hostname',
                    'value' => fn($model) => $model->hostname,
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
                    'value' => fn($model) => $model->ram ?? '-',
                ],
                [
                    'label' => 'OS',
                    'value' => fn($model) => $model->os ?? '-',
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
                    'label' => 'Monitor 1',
                    'value' => function ($model) {
                        $monitor = Monitor::findIdentity($model->monitor_id1);
                        return $monitor
                            ? "{$monitor->brand} {$monitor->model} (S/N: {$monitor->s_n})"
                            : '-';
                    },
                ],
                [
                    'label' => 'Monitor 2',
                    'value' => function ($model) {
                        $monitor = Monitor::findIdentity($model->monitor_id2);
                        return $monitor
                            ? "{$monitor->brand} {$monitor->model} (S/N: {$monitor->s_n})"
                            : '-';
                    },
                ],
                [
                    'label' => 'Leírás',
                    'value' => fn($model) => $model->description ?? '-',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                '<i class="bi bi-pencil-square"></i>', ['workstation/update', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Módosítás',
                                    'data' => [
                                        'method' => 'get',
                                        'pjax' => '1',
                                    ],
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>


        <div class="row">
            <div class="col-lg-4 mb-3">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $cpuProvider,
                    'columns' => [
                        [
                            'label' => 'Brand',
                            'value' => fn($model) => $model->brand ?? '-',
                        ],
                        [
                            'label' => 'Modell',
                            'value' => fn($model) => $model->model ?? '-',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="bi bi-trash"></i>', ['cpu/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Törlés',
                                        'data' => [
                                            'confirm' => 'Biztosan törlöd?',
                                            'method' => 'post',
                                            'pjax' => '1',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
            <div class="col-lg-4 mb-3">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $officeProvider,
                    'columns' => [
                        [
                            'label' => 'Iroda',
                            'value' => fn($model) => $model->name ?? '-',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="bi bi-trash"></i>', ['office/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Törlés',
                                        'data' => [
                                            'confirm' => 'Biztosan törlöd?',
                                            'method' => 'post',
                                            'pjax' => '1',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
            <div class="col-lg-4">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $monitorProvider,
                    'columns' => [
                        [
                            'label' => 'Brand',
                            'value' => fn($model) => $model->brand ?? '-',
                        ],
                        [
                            'label' => 'Modell',
                            'value' => fn($model) => $model->model ?? '-',
                        ],
                        [
                            'label' => 'S/N',
                            'value' => fn($model) => $model->s_n ?? '-',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="bi bi-trash"></i>', ['monitor/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Törlés',
                                        'data' => [
                                            'confirm' => 'Biztosan törlöd?',
                                            'method' => 'post',
                                            'pjax' => '1',
                                        ],
                                    ]);
                                },
                            ],
                        ],

                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $colleagueProvider,
                    'columns' => [
                        [
                            'label' => 'Név',
                            'value' => fn($model) => $model->name ?? '-',
                        ],
                        [
                            'label' => 'Iroda',
                            'value' => fn($model) => $model->department ?? '-',
                        ],
                        [
                            'label' => 'Csoport',
                            'value' => fn($model) => $model->group ?? '-',
                        ],
                        [
                            'label' => 'Itt dolgozik még?',
                            'value' => function($model) {
                                if (!$model->archived) {
                                    return 'Igen';
                                } else {
                                    return "Nem";
                                }
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<i class="bi bi-trash"></i>', ['colleague/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Törlés',
                                        'data' => [
                                            'confirm' => 'Biztosan törlöd?',
                                            'method' => 'post',
                                            'pjax' => '1',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>

        </div>


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
