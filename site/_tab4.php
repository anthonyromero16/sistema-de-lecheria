<?php
use yii\helpers\Url;
$this->registerJsFile("@web/js/calendario.js", ['depends' => [\yii\web\JqueryAsset::class]]);

?>

<section id="tab4" class="tab-content">
            <h2>Calendario de Salud </h2>

            <div class="health-container">
                <!-- Panel izquierdo: Mini calendario y próximas citas -->
                <div class="calendar-sidebar">
                    <div class="mini-calendar">
                        <div class="calendar-header">
                            <button id="prevMonth">&lt;</button>
                            <h3 id="currentMonth">Septiembre 2025</h3>
                            <button id="nextMonth">&gt;</button>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                            <!-- Días del mes se generarán con JavaScript -->
                        </div>
                    </div>

                    <div class="upcoming-events">
                        <h3>Próximas Citas</h3>
                        <div id="upcomingList">
                            <!-- Eventos próximos se cargarán aquí -->
                        </div>
                    </div>
                </div>

                <!-- Panel derecho: Lista de vacas y sus tratamientos -->
                <div class="cows-list">
                    <h3>Lista de Vacas</h3>
                    <div class="search-box">
                        <input type="text" id="searchCow" placeholder="Buscar vaca por nombre o ID...">
                    </div>
                    <div class="cows-grid" id="cowsGrid">
                        <!-- Lista de vacas se generará con JavaScript -->
                    </div>
                </div>
            </div>
        </section>
        <?= $this->render('modalcalendario') ?>