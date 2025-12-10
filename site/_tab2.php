<?php
use yii\helpers\Url;
$this->registerJsFile("@web/js/modal.js", ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<section id="tab2" class="tab-content">
    <h2>Ficha de animales — Producción y salud</h2>

    <div class="wrap">
        <h3>Registro de vacas — Haz clic para ver detalles</h3>

        <!-- Aquí se llenan las vacas desde JS -->
        <div id="cowGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;"></div>
        </div>

</section>
<?= $this->render('modalvaca') ?>
