// Función para abrir las pestañas (si lo usas en otra sección)
function openTab(evt, tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-btn');

    tabs.forEach(tab => tab.classList.remove('active'));
    buttons.forEach(btn => btn.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    evt.currentTarget.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {

    // REQUEST para obtener imagen del usuario desde la BD
    fetch('index.php?r=site/get-profile-image')
        .then(response => response.json())
        .then(data => {
            const img = document.getElementById('menuProfileImage');
            if (img && data.url) {
                img.src = data.url;
            }
        });

    // ------ MENÚ DE USUARIO (corregido) --------
    const btn = document.querySelector('.menu-btn');
    const menu = document.querySelector('.menu-options');  // ← CORRECCIÓN

    function toggleUserMenu() {
        menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
    }

    btn.addEventListener('click', toggleUserMenu);

    // Cerrar al hacer clic fuera
    document.addEventListener('click', function (event) {
        if (!menu.contains(event.target) && !btn.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
});
