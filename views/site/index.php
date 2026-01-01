<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use app\widgets\ModularModal;

echo ModularModal::widget();
 /*
$this->title = 'IT Leltár';

$this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['position' => \yii\web\View::POS_HEAD]);

$js = "
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Status', 'Count'],
            ['Online', $online],
            ['Offline', $offline]
        ]);

        var options = {
            title: 'Real-time Network Status',
            colors: ['#28a745', '#dc3545'], // Green and Red
            is3D: true,
            chartArea: {width: '90%', height: '80%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('ping_chart'));
        chart.draw(data, options);
    }
";
$this->registerJs($js);*/
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">IT Leltár</h1>

        <p class="lead">Hódmezővásárhely Megyei Jogú Város Polgármesteri Hivatalának és Önkormányzatának informatikai leltára.</p>

        <p>
            <a class="btn btn-lg btn-success" href="index.php?r=site%2Fnew-workstation">Új munkaállomás felvétele!</a>
            <a class="btn btn-lg btn-success" href="index.php?r=site%2Fnew-maintenance">Új karbantartás felvétele!</a>
            <a class="btn btn-lg btn-success" href="index.php?r=site%2Fmanage-data">Ugrás az adatokhoz!</a>
        </p>
    </div>

    <!--
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Diagram helye</h2>

                <div class="network-status-view">
                    <h1><?= Html::encode($this->title) ?></h1>

                    <div class="row">
                        <div class="col-md-8">
                            <div id="ping_chart" style="width: 100%; height: 500px; border: 1px solid #ddd;"></div>
                        </div>
                        <div class="col-md-4">
                            <h3>Summary</h3>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    Online <span class="badge badge-success"><?php //$online ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    Offline <span class="badge badge-danger"><?php //$offline ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="col-lg-4 mb-3">
                <h2>Diagram helye</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
            </div>
            <div class="col-lg-4">
                <h2>Diagram helye</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
            </div>
        </div>
    </div>
</div>
