<?php
use yii\helpers\Url;

// Chart.js primero
$this->registerJsFile("https://cdn.jsdelivr.net/npm/chart.js", [
    'depends' => [\yii\web\JqueryAsset::class]
]);

// Tu archivo de dashboard
$this->registerJsFile("@web/js/dashboard.js", [
    'depends' => [\yii\web\JqueryAsset::class]
]);
?>

<section id="tab3" class="tab-content">
    <h2>Dashboard de Producción y Gestión</h2>

    <div id="dashboard">

        <!-- Gráfico por Día -->
        <div class="chart">
            <h3>Producción por Día</h3>
            <canvas id="chartPorDia"></canvas>
        </div>

        <!-- Gráfico por Animal -->
        <div class="chart">
            <h3>Producción por Animal</h3>
            <canvas id="chartPorAnimal"></canvas>
        </div>

        <!-- Gráfico por Tipo de Leche -->
        <div class="chart">
            <h3>Producción por Tipo de Leche</h3>
            <canvas id="chartPorTipoLeche"></canvas>
        </div>

    </div>
</section>
