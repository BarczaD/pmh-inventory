<?php
use yii\helpers\Html;
$this->title = 'Rendszerhiba';
?>
<div class="site-db-offline mt-5 text-center">
    <div class="display-1 text-danger mb-4">
        <i class="fas fa-database"></i> <i class="fas fa-times-circle"></i>
    </div>

    <h1 class="text-dark fw-bold">Karbantartás vagy Hiba</h1>
    <p class="lead text-muted">Az adatbázis-szerver nem válaszol. Kérjük, próbálkozzon később.</p>

    <div class="mt-4">
        <button onclick="window.location.reload();" class="btn btn-primary btn-lg">
            <i class="fas fa-sync-alt"></i> Oldal frissítése
        </button>
    </div>

    <?php if (YII_DEBUG): ?>
        <div class="alert alert-warning mt-5 text-start d-inline-block">
            <strong>Debug Info:</strong><br>
            <code><?= Html::encode($exception->getMessage()) ?></code>
        </div>
    <?php endif; ?>
</div>