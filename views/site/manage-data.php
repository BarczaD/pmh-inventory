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

$this->title = 'Adatok Kezelése';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-5">Adatok kezelése</h1>
    </div>

    <div class="body-content">

        <?php Pjax::begin(); ?>

        <div class="workstation-search mb-3">
            <h5>Munkaállomások</h5>
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['manage-data'],
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
                        'attribute' => 'anydesk_code', // Adjust this to your actual DB column name
                        'label' => 'AnyDesk kód',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!$model->anydesk_code) {
                                return '<span class="text-muted">-</span>';
                            }

                            // Remove spaces so the AnyDesk app can read the ID correctly
                            $cleanId = str_replace(' ', '', $model->anydesk_code);

                            return Html::a(
                                    '<i class="fas fa-external-link-alt"></i> ' . Html::encode($model->anydesk_code),
                                    "anydesk:{$cleanId}",
                                    [
                                            'class' => 'btn btn-sm btn-outline-primary w-100',
                                            'title' => 'Csatlakozás AnyDesk-kel',
                                            'style' => 'font-family: monospace;'
                                    ]
                            );
                        },
                        'contentOptions' => ['style' => 'width: 150px; text-align: center;'],
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


        <div class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <h5>CPU <?php echo Html::a('+', ['cpu/create'], [
                                'class' => 'btn btn-primary',
                                'data-toggle' => 'universal-modal',
                        ]); ?></h5>
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
                </div>
                <div class="col-md-3">
                    <h5>Irodák <?php echo Html::a('+', ['office/create'], [
                                'class' => 'btn btn-primary',
                                'data-toggle' => 'universal-modal',
                        ]); ?></h5>
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
                </div>
                <div class="col-md-3">
                    <h5>Brandek <?php echo Html::a('+', ['brand/create'], [
                                'class' => 'btn btn-primary',
                                'data-toggle' => 'universal-modal',
                        ]); ?></h5>
                    <?= GridView::widget([
                        'dataProvider' => $brandProvider,
                        'columns' => [
                            [
                                'label' => 'PC Brand',
                                'value' => fn($model) => $model->name ?? '-',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<i class="bi bi-trash"></i>', ['brand/delete', 'id' => $model->id], [
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
                        ]
                    ])

                    ?>
                </div>
                <div class="col-md-3">
                    <h5>Monitorok <?php echo Html::a('+', ['monitor/create'], [
                                'class' => 'btn btn-primary',
                                'data-toggle' => 'universal-modal',
                        ]); ?></h5>
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
                                'label' => 'Leírás',
                                'value' => fn($model) => $model->description ?? '-',
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
                </div>
            </div>
            <div class="row">
                <h5>Kollégák <?php echo Html::a('+', ['colleague/create'], [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'universal-modal',
                    ]); ?></h5>
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
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{toggle-archive}',
                            'buttons' => [
                                'toggle-archive' => function ($url, $model) {
                                    $icon = $model->archived ? 'bi bi-box-arrow-in-down' : 'bi bi-box-arrow-up';
                                    $label = $model->archived == 1 ? 'Visszaállítás' : 'Archiválás';

                                    return Html::a(
                                        "<i class='$icon'></i> $label",
                                        ['colleague/toggle-archive', 'id' => $model->id],
                                        [
                                            'class' => 'btn btn-sm btn-outline-secondary',
                                            'title' => $label,
                                            'data' => [
                                                'confirm' => 'Biztosan megváltoztatod az archíválási állapotot?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>

        <?php
        /*
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
        */
        ?>

    </div>
</div>
