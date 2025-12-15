// profile_ganado.js
(function () {
    // Helpers seguros
    const $ = sel => document.querySelector(sel);
    const $$ = sel => Array.from(document.querySelectorAll(sel));

    // Esperar a DOM
    document.addEventListener('DOMContentLoaded', () => {
        console.log('[profile_ganado] DOM listo');

        // Rutas (si no vienen definidas en window, dejar como cadena vacía)
        const routeAgregarAnimal = window.routeAgregarAnimal || '';
        const routeActualizarAnimal = window.routeActualizarAnimal || '';

        // ELEMENTOS
        const inputSearch = $('#searchId');
        const tableBody = document.querySelector('#tablaGanado tbody');
        const modalVaca = $('#modalVaca');
        const btnAgregar = $('#btnAgregarVaca');
        const btnCerrar = $('#cerrarModal'); // botón cancelar del modalVaca
        const modalTitle = $('#modalTitle');
        const submitBtn = $('#submitBtn');

        // Seguridad: logs si faltan elementos esenciales
        if (!tableBody) console.warn('[profile_ganado] tabla #tablaGanado no encontrada o no tiene <tbody>');
        if (!btnAgregar) console.warn('[profile_ganado] botón #btnAgregarVaca no encontrado');
        if (!modalVaca) console.warn('[profile_ganado] modal #modalVaca no encontrado');
        if (!submitBtn) console.warn('[profile_ganado] botón #submitBtn no encontrado');

        /* -------------------------
           BÚSQUEDA POR ID
        ------------------------- */
        if (inputSearch && tableBody) {
            inputSearch.addEventListener('keyup', () => {
                const t = inputSearch.value.trim();
                [...tableBody.rows].forEach(row => {
                    row.style.display = row.cells[0].textContent.includes(t) ? '' : 'none';
                });
            });
        }

        /* -------------------------
           FUNCIONES DE ABRIR/CERRAR MODAL (reutilizables)
        ------------------------- */
        function abrirModal(el) {
            if (!el) return;
            el.style.display = 'flex';
            el.setAttribute('data-open', 'true');
            document.body.classList.add('modal-open');
        }
        function cerrarModal(el) {
            if (!el) return;
            el.style.display = 'none';
            el.removeAttribute('data-open');
            document.body.classList.remove('modal-open');
        }

        /* -------------------------
           AGREGAR NUEVA VACA (modal)
        ------------------------- */
        if (btnAgregar) {
            btnAgregar.addEventListener('click', () => {
                if (modalTitle) modalTitle.textContent = 'Agregar Nueva Vaca';
                if (submitBtn) submitBtn.textContent = 'Agregar';
                const form = $('#formVaca');
                if (form && routeAgregarAnimal) form.action = routeAgregarAnimal;
                // limpiar campos si existen
                const idsToClear = ['id_animal', 'nombre', 'descripcion', 'id_raza', 'fecha_nacimiento', 'peso_kg', 'temperatura_celsius'];
                idsToClear.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.value = '';
                });
                abrirModal(modalVaca);
            });
        }

        if (btnCerrar) btnCerrar.addEventListener('click', () => cerrarModal(modalVaca));

        /* -------------------------
           ACTUALIZAR VACA (delegación por si filas se generan)
        ------------------------- */
        document.addEventListener('click', (e) => {
            const btn = e.target.closest && e.target.closest('.btnActualizar');
            if (!btn) return;
            e.preventDefault();

            const row = btn.closest('tr');
            if (!row) {
                console.warn('fila no encontrada para actualizar');
                return;
            }

            const map = {
                id_animal: row.dataset.id,
                nombre: row.dataset.nombre,
                descripcion: row.dataset.descripcion,
                id_raza: row.dataset.id_raza,
                fecha_nacimiento: row.dataset.fecha_nacimiento,
                peso_kg: row.dataset.peso,
                temperatura_celsius: row.dataset.temperatura
            };

            Object.entries(map).forEach(([id, val]) => {
                const el = document.getElementById(id);
                if (el) el.value = val ?? '';
            });

            if (modalTitle) modalTitle.textContent = 'Actualizar Vaca';
            if (submitBtn) submitBtn.textContent = 'Guardar cambios';
            const form = $('#formVaca');
            if (form && routeActualizarAnimal) form.action = routeActualizarAnimal;
            abrirModal(modalVaca);
        });

        /* -------------------------
           PRODUCCIÓN / VETERINARIA / VACUNAS (delegación)
        ------------------------- */

        // función para renderizar lista simple
        function renderLista(containerId, datos, renderer) {
            const cont = document.getElementById(containerId);
            if (!cont) return;
            if (!Array.isArray(datos) || datos.length === 0) {
                cont.innerHTML = '<p>No hay registros</p>';
                return;
            }
            cont.innerHTML = datos.map(item => renderer(item)).join('');
        }

        // PRODUCCION
        document.addEventListener('click', (e) => {
            const btn = e.target.closest && e.target.closest('.btnProduccion');
            if (!btn) return;
            e.preventDefault();
            const id = btn.dataset.id;
            const prodData = JSON.parse(btn.dataset.produccion || '[]');
            if (document.getElementById('prod_id_animal')) document.getElementById('prod_id_animal').value = id;
            renderLista('listaProduccion', prodData, p => `
                <div class="itemRegistro">
                    <strong>${p.fecha_extraido || ''}</strong> — ${p.litros || ''} litros — ${p.tipo_leche || ''}
                </div>
            `);
            abrirModal(document.getElementById('modalProduccion'));
        });

        // cerrar producción (si existe)
        const cerrarProd = document.getElementById('cerrarModalProduccion');
        if (cerrarProd) cerrarProd.addEventListener('click', () => cerrarModal(document.getElementById('modalProduccion')));

        // VETERINARIA
        document.addEventListener('click', (e) => {
            const btn = e.target.closest && e.target.closest('.btnVeterinaria');
            if (!btn) return;
            e.preventDefault();
            const id = btn.dataset.id;
            const vetData = JSON.parse(btn.dataset.veterinaria || '[]');
            if (document.getElementById('vet_id_animal')) document.getElementById('vet_id_animal').value = id;
            renderLista('listaVeterinaria', vetData, v => `
                <div class="itemRegistro">
                    <strong>${v.fecha || ''}</strong> — ${v.tipo_evento || ''}<br>${v.descripcion || ''}
                </div>
            `);
            abrirModal(document.getElementById('modalVeterinaria'));
        });
        const cerrarVet = document.getElementById('cerrarModalVeterinaria');
        if (cerrarVet) cerrarVet.addEventListener('click', () => cerrarModal(document.getElementById('modalVeterinaria')));

        // VACUNAS
        document.addEventListener('click', (e) => {
            const btn = e.target.closest && e.target.closest('.btnVacunas');
            if (!btn) return;
            e.preventDefault();
            const id = btn.dataset.id;
            const vacData = JSON.parse(btn.dataset.vacunas || '[]');
            if (document.getElementById('vac_id_animal')) document.getElementById('vac_id_animal').value = id;
            renderLista('listaVacunas', vacData, v => `
                <div class="itemRegistro">
                    <strong>${v.fecha_aplicacion || ''}</strong> — ${v.nombre || v.nombre_vacuna || ''}<br>${v.observaciones || ''}
                </div>
            `);
            abrirModal(document.getElementById('modalVacunas'));
        });
        const cerrarVac = document.getElementById('cerrarModalVacunas');
        if (cerrarVac) cerrarVac.addEventListener('click', () => cerrarModal(document.getElementById('modalVacunas')));

        /* -------------------------
           Eliminar: confirmar link (delegación)
        ------------------------- */
        document.addEventListener('click', (e) => {
            const a = e.target.closest && e.target.closest('a[href*="delete-animal"]');
            if (!a) return;
            if (!confirm('¿Deseas eliminar este animal?')) {
                e.preventDefault();
            }
        });

        console.log('[profile_ganado] inicialización completa');
    }); // DOMContentLoaded end
})();
