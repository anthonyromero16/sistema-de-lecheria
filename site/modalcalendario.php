<!-- MODAL DE FICHA (mostrarFicha) -->
<div id="fichaBackdrop" class="modal-backdrop" style="display:none;">
    <div class="modal-container">

        <div class="modal-header">
            <h2>Ficha de la Vaca</h2>
            <button id="fichaCloseBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">

            <p><strong>ID:</strong> <span id="fichaCowId">-</span></p>

            <p><strong>Nombre:</strong> <span id="fichaCowName">-</span></p>

            <p><strong>Raza:</strong> <span id="fichaCowBreed">-</span></p>

            <p><strong>Descripcion:</strong></p>
            <p id="fichaCowDesc">-</p>

            <hr>

            <h3>Vacunas</h3>
            <ul id="fichaVaccineList"></ul>

            <h3>Eventos</h3>
            <ul id="fichaEventList"></ul>

        </div>

    </div>
</div>

