<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use app\widgets\ModularModal;

echo ModularModal::widget();

$this->title = 'My Yii Application';
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

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Diagram helye</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>
            </div>
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
