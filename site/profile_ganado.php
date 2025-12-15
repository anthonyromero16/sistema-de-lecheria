<?php
/* @var $user app\models\Usuarios */
/* @var $ganado array|null */
/* @var $razas array|null */
/* @var $vacunas array|null */
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/profile_ganado.css">
<script src="<?= Yii::$app->request->baseUrl ?>/js/profile_ganado.js"></script>

<div id="ganado-wrapper">

    <!-- Título -->
    <h1 id="tituloGanado">Mi Ganado</h1>

    <!-- Bienvenida -->
    <p id="bienvenidaTexto">
        Bienvenido, <?= htmlspecialchars($user->nombre) ?>. Aquí puedes ver tu ganado registrado.
    </p>

    <!-- Botón Volver -->
    <button id="btnVolver" onclick="window.location.href='<?= Yii::$app->request->baseUrl ?>/site/index'">
        ← Volver
    </button>

    <!-- Botón Nueva Vaca -->
    <button id="btnAgregarVaca">Agregar Nueva Vaca</button>

    <?php if (!empty($ganado)): ?>

    <!-- Buscador -->
    <label for="searchId" id="labelBuscar">Buscar por ID:</label>
    <input type="text" id="searchId" placeholder="Escribe el ID">

    <!-- TABLA -->
    <table id="tablaGanado">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Peso (kg)</th>
                <th>Temperatura (°C)</th>
                <th>Fecha de Nacimiento</th>
                <th>Producción</th>
                <th>Veterinaria</th>
                <th>Vacunas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ganado as $animal): ?>
                <tr 
                    data-id="<?= $animal->id ?>" 
                    data-nombre="<?= htmlspecialchars($animal->nombre) ?>" 
                    data-descripcion="<?= htmlspecialchars($animal->descripcion) ?>" 
                    data-id_raza="<?= $animal->id_raza ?>" 
                    data-fecha_nacimiento="<?= $animal->fecha_nacimiento ?>" 
                    data-peso="<?= $animal->peso_kg ?>" 
                    data-temperatura="<?= $animal->temperatura_celsius ?>"
                >
                    <td><?= htmlspecialchars($animal->id) ?></td>
                    <td><?= htmlspecialchars($animal->nombre) ?></td>
                    <td><?= htmlspecialchars($animal->raza ? $animal->raza->nombre : '-') ?></td>
                    <td><?= htmlspecialchars($animal->peso_kg) ?></td>
                    <td><?= htmlspecialchars($animal->temperatura_celsius) ?></td>
                    <td><?= htmlspecialchars($animal->fecha_nacimiento) ?></td>
                    <td>
                        <a href="#" class="btnProduccion" data-id="<?= $animal->id ?>" data-produccion='<?= json_encode($animal->produccion ?? []) ?>'>Ver / Agregar</a>
                    </td>
                    <td>
                        <a href="#" class="btnVeterinaria" data-id="<?= $animal->id ?>" data-veterinaria='<?= json_encode($animal->veterinaria ?? []) ?>'>Ver / Agregar</a>
                    </td>
                    <td>
                        <a href="#" class="btnVacunas" data-id="<?= $animal->id ?>" data-vacunas='<?= json_encode($animal->vacunas ?? []) ?>'>Ver / Agregar</a>
                    </td>
                    <td>
                        <a href="#" class="btnActualizar">Actualizar</a> |
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/delete-animal', 'id' => $animal->id]) ?>" onclick="return confirm('¿Deseas eliminar este animal?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
        <p id="mensajeNoGanado">No tienes ganado registrado.</p>
    <?php endif; ?>

</div>


<!-- MODAL AGREGAR / EDITAR -->
<div id="modalVaca" class="modal-overlay">
    <div class="modal-contenido">
        <h3 id="modalTitle">Agregar Nueva Vaca</h3>

        <form id="formVaca" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/agregar-animal']) ?>" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <input type="hidden" name="id_animal" id="id_animal">

            <label>Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label>Descripción:</label>
            <textarea name="descripcion" id="descripcion"></textarea>

            <label>Imagen (opcional):</label>
            <input type="file" name="imagen" accept="image/*">

            <label>Raza:</label>
            <select name="id_raza" id="id_raza" required>
                <option value="">Seleccionar</option>
                <?php foreach($razas as $raza): ?>
                    <option value="<?= $raza->id ?>"><?= htmlspecialchars($raza->nombre) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">

            <label>Peso (kg):</label>
            <input type="number" name="peso_kg" id="peso_kg" step="0.01" required>

            <label>Temperatura (°C):</label>
            <input type="number" name="temperatura_celsius" id="temperatura_celsius" step="0.1" required>

            <button type="submit" id="submitBtn">Agregar</button>
            <button type="button" id="cerrarModal">Cancelar</button>
        </form>
    </div>
</div>


<!-- MODAL PRODUCCIÓN -->
<div id="modalProduccion" class="modal-overlay">
    <div class="modal-contenido">
        <h3>Producción</h3>

        <div id="listaProduccion" class="listaModal"></div>

        <form id="formProduccion" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/produccion']) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <input type="hidden" name="id_animal" id="prod_id_animal">

            <label>Fecha Extraído:</label>
            <input type="date" name="fecha_extraido" id="fecha_extraido" required>

            <label>Litros:</label>
            <input type="number" name="litros" id="litros" step="0.01" required>

            <label>Tipo de Leche:</label>
            <input type="text" name="tipo_leche" id="tipo_leche" required>

            <button type="submit">Guardar</button>
            <button type="button" id="cerrarModalProduccion">Cerrar</button>
        </form>
    </div>
</div>


<!-- MODAL VETERINARIA -->
<div id="modalVeterinaria" class="modal-overlay">
    <div class="modal-contenido">
        <h3>Veterinaria</h3>

        <div id="listaVeterinaria" class="listaModal"></div>

        <form id="formVeterinaria" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/veterinaria']) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <input type="hidden" name="id_animal" id="vet_id_animal">

            <label>Tipo Evento:</label>
            <input type="text" name="tipo_evento" id="tipo_evento" required>

            <label>Descripción:</label>
            <textarea name="descripcion" id="vet_descripcion" required></textarea>

            <label>Fecha:</label>
            <input type="date" name="fecha" id="vet_fecha" required>

            <button type="submit">Guardar</button>
            <button type="button" id="cerrarModalVeterinaria">Cerrar</button>
        </form>
    </div>
</div>


<!-- MODAL VACUNAS -->
<div id="modalVacunas" class="modal-overlay">
    <div class="modal-contenido">
        <h3>Vacunas</h3>

        <div id="listaVacunas" class="listaModal"></div>

        <form id="formVacunas" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/vacunas']) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <input type="hidden" name="id_animal" id="vac_id_animal">

            <label>Vacuna:</label>
            <select name="id_vacuna" id="id_vacuna" required>
                <option value="">Seleccionar</option>
                <?php foreach($vacunas as $vacuna): ?>
                    <option value="<?= $vacuna->id ?>"><?= htmlspecialchars($vacuna->nombre) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Fecha Aplicación:</label>
            <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required>

            <label>Observaciones:</label>
            <textarea name="observaciones" id="observaciones"></textarea>

            <button type="submit">Guardar</button>
            <button type="button" id="cerrarModalVacunas">Cerrar</button>
        </form>
    </div>
</div>

<script>
    const routeAgregarAnimal = "<?= Yii::$app->urlManager->createUrl(['site/agregar-animal']) ?>";
    const routeActualizarAnimal = "<?= Yii::$app->urlManager->createUrl(['site/update-animal']) ?>";
</script>

