<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\User;

$this->title = 'Rendszernapló';
?>

<div class="site-logs">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= \yii\helpers\Url::to(['site/log']) ?>" method="get">
                <input type="hidden" name="r" value="site/log">

                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="event_description" class="form-label font-weight-bold">Esemény leírása</label>
                        <?= Html::textInput('event_description', $searchDescription, [
                                'id' => 'event_description',
                                'class' => 'form-control',
                                'placeholder' => 'Pl. CPU létrehozva, Kolléga törölve...'
                        ]) ?>
                    </div>

                    <div class="col-md-3">
                        <label for="log_date" class="form-label font-weight-bold">Dátum</label>
                        <?= Html::input('date', 'log_date', $searchDate, [
                                'id' => 'log_date',
                                'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="col-md-3">
                        <label for="triggered_by" class="form-label font-weight-bold">Felhasználó</label>
                        <?= Html::dropDownList('triggered_by', $searchUser,
                                ArrayHelper::map(User::find()->all(), 'id', 'username'),
                                [
                                        'id' => 'triggered_by',
                                        'class' => 'form-select',
                                        'prompt' => 'Összes felhasználó'
                                ]
                        ) ?>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <?= Html::submitButton('<i class="fas fa-search"></i> Keresés', ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Alaphelyzet', ['site/log'], ['class' => 'btn btn-outline-secondary']) ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover mb-0 align-middle'],
                    'layout' => "{items}\n<div class='p-3 border-top text-center'>{pager}</div>",
                    'columns' => [
                            [
                                    'attribute' => 'log_date',
                                    'label' => 'Időpont',
                                    'format' => ['datetime', 'php:Y-m-d H:i:s'],
                                    'contentOptions' => ['style' => 'width: 180px; font-family: monospace;'],
                            ],
                            [
                                    'label' => 'Szint',
                                    'format' => 'raw',
                                    'value' => function($model) { return $model->getAlertBadge(); },
                                    'contentOptions' => ['style' => 'width: 130px;'],
                            ],
                            [
                                    'attribute' => 'event_type',
                                    'label' => 'Típus',
                                    'value' => function($model) { return $model->getEventLabel(); }
                            ],
                            [
                                    'attribute' => 'event_description',
                                    'label' => 'Esemény részletei',
                                    'format' => 'ntext',
                            ],
                            [
                                    'label' => 'Felhasználó',
                                    'value' => function($model) { return $model->user->username ?? 'Rendszer'; },
                                    'contentOptions' => ['style' => 'width: 150px; font-style: italic;'],
                            ],
                    ],
            ]); ?>
        </div>
    </div>
</div>