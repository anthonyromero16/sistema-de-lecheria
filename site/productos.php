<?php
/* @var $this yii\web\View */
$this->title = 'Lacteos y Quesos | Airehcel Principal';
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/estilos.css">
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/productos.css">
<link rel="icon" href="<?= Yii::$app->request->baseUrl ?>/images/logos/Logo-Lacteos-Quesos-Don-Joaquin.png" type="image/png">

<header id="home">

<div class="user-menu">
    <button class="menu-btn user-btn" onclick="toggleMenu(this)">
        
        <?php if (Yii::$app->user->isGuest): ?>

            <span class="user-name">Iniciar sesión</span>

        <?php else: ?>

            <img id="menuProfileImage" class="user-avatar"
                 src="<?= Yii::$app->request->baseUrl ?>/images/users/default.png">

            <span class="user-name">
                <?= htmlspecialchars(Yii::$app->user->identity->nombre) ?>
            </span>

        <?php endif; ?>

    </button>

    <div class="menu-options">

        <?php if (Yii::$app->user->isGuest): ?>

            <a href="<?= Yii::$app->urlManager->createUrl(['site/login']) ?>">Login</a>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/register']) ?>">Register</a>

        <?php else: ?>

            <a href="<?= Yii::$app->urlManager->createUrl(['site/profile']) ?>">Profile</a>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/profile-ganado']) ?>">Mi Ganado</a>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/logout']) ?>" data-method="post">Logout</a>

        <?php endif; ?>

    </div>
</div>


    <img src="<?= Yii::$app->request->baseUrl ?>/images/logos/Logo-Lacteos-Quesos-Don-Joaquin.png" class="logo-header">
     <div class="redes-header">
    <a href="https://www.facebook.com/donjoaquinlacteos/" target="_blank">
        <svg viewBox="0 0 24 24">
            <path fill="currentColor" d="M17 1H7C3.69 1 1 3.69 1 7V17C1 20.31 3.69 23 7 23H17C20.31 23 23 20.31 23 17V7C23 3.69 20.31 1 17 1ZM15.5 15H13V21H10V15H8V12H10V10C10 7.86 11.23 6 14.5 6H17V9H15.5C14.12 9 14.5 9.77 14.5 10.77V12H17L16.5 15Z"/>
        </svg>
    </a>
    
    <a href="https://www.instagram.com/donjoaquinlacteos/" target="_blank">
        <svg viewBox="0 0 24 24">
            <path fill="currentColor" d="M12 2C9.17 2 8.83 2 7.83 2.05C6.77 2.1 6.05 2.18 5.43 2.41C4.81 2.64 4.25 2.97 3.73 3.49C3.21 4.01 2.88 4.57 2.65 5.19C2.42 5.81 2.34 6.53 2.29 7.59C2.24 8.59 2.24 9.17 2.24 12C2.24 14.83 2.24 15.41 2.29 16.41C2.34 17.47 2.42 18.19 2.65 18.81C2.88 19.43 3.21 19.99 3.73 20.51C4.25 21.03 4.81 21.36 5.43 21.59C6.05 21.82 6.77 21.9 7.83 21.95C8.83 22 9.17 22 12 22C14.83 22 15.17 22 16.17 21.95C17.23 21.9 17.95 21.82 18.57 21.59C19.19 21.36 19.75 21.03 20.27 20.51C20.79 19.99 21.12 19.43 21.35 18.81C21.58 18.19 21.66 17.47 21.71 16.41C21.76 15.41 21.76 14.83 21.76 12C21.76 9.17 21.76 8.59 21.71 7.59C21.66 6.53 21.58 5.81 21.35 5.19C21.12 4.57 20.79 4.01 20.27 3.49C19.75 2.97 19.19 2.64 18.57 2.41C17.95 2.18 17.23 2.1 16.17 2.05C15.17 2 14.83 2 12 2ZM12 4C14.71 4 15.05 4 16.05 4.05C17.07 4.1 17.67 4.18 18.1 4.35C18.53 4.52 18.88 4.77 19.19 5.08C19.5 5.39 19.75 5.74 19.92 6.17C20.09 6.6 20.17 7.2 20.22 8.22C20.27 9.22 20.27 9.56 20.27 12C20.27 14.44 20.27 14.78 20.22 15.78C20.17 16.8 20.09 17.4 19.92 17.83C19.75 18.26 19.5 18.61 19.19 18.92C18.88 19.23 18.53 19.48 18.1 19.65C17.67 19.82 17.07 19.9 16.05 19.95C15.05 20 14.71 20 12 20C9.29 20 8.95 20 7.95 19.95C6.93 19.9 6.33 19.82 5.9 19.65C5.47 19.48 5.12 19.23 4.81 18.92C4.5 18.61 4.25 18.26 4.08 17.83C3.91 17.4 3.83 16.8 3.78 15.78C3.73 14.78 3.73 14.44 3.73 12C3.73 9.56 3.73 9.22 3.78 8.22C3.83 7.2 3.91 6.6 4.08 6.17C4.25 5.74 4.5 5.39 4.81 5.08C5.12 4.77 5.47 4.52 5.9 4.35C6.33 4.18 6.93 4.1 7.95 4.05C8.95 4 9.29 4 12 4ZM12 7.75C9.66 7.75 7.75 9.66 7.75 12C7.75 14.34 9.66 16.25 12 16.25C14.34 16.25 16.25 14.34 16.25 12C16.25 9.66 14.34 7.75 12 7.75ZM12 14.25C10.7 14.25 9.75 13.3 9.75 12C9.75 10.7 10.7 9.75 12 9.75C13.3 9.75 14.25 10.7 14.25 12C14.25 13.3 13.3 14.25 12 14.25ZM18.43 5.84C18.8 5.84 19.1 6.14 19.1 6.51C19.1 6.88 18.8 7.18 18.43 7.18C18.06 7.18 17.76 6.88 17.76 6.51C17.76 6.14 18.06 5.84 18.43 5.84Z"/>
        </svg>
    </a>
    
    <a href="https://x.com/donjoaquinlacteos" target="_blank">
        <svg viewBox="0 0 24 24">
            <path fill="currentColor" d="M18.9 4.2C19.1 4 19.3 4 19.5 4H22.5L16.2 11.4L23 20H17.7L12.7 13.8L7 20H4L10.9 12.3L4 4H9.3L13.8 9.5L18.9 4.2ZM18.5 18H20.1L8.3 6H6.6L18.5 18Z"/>
        </svg>
        </a>
    </div>

     <h1>Bienvenidos a L&aacute;cteos y Quesos Don Joaqu&iacute;n</h1>
    <p class="subtitulo">El sabor fresco y artesanal que nos distingue</p>
</header>

<nav class="w3-bar">
    <a href="<?= Yii::$app->request->baseUrl ?>/site/index" class="w3-button w3-bar-item">HOME</a>
    <a href="<?= Yii::$app->urlManager->createUrl(['site/productos']) ?>" class="w3-button w3-bar-item">PRODUCTOS</a>
    <a href="<?= Yii::$app->urlManager->createUrl(['site/ganado']) ?>" class="w3-button w3-bar-item">GANADO</a>
    <a href="<?= Yii::$app->urlManager->createUrl(['site/nosotros']) ?>" class="w3-button w3-bar-item">NOSOTROS</a>    
    <a href="<?= Yii::$app->urlManager->createUrl(['site/contactos']) ?>" class="w3-button w3-bar-item">CONTACTOS</a>
</nav>

<main>

    <!-- Sección Leches -->
   <div class="titulo-principal">
    <h2>Leches</h2>
</div>

<div class="carrusel-wrapper">
    <button class="carrusel-btn prev">&lt;</button>
    <section class="carrusel1">
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/leche1.jpg" alt="Leche Entera">
            <h3>Leche Entera</h3>
            <p>Leche fresca y nutritiva para toda la familia.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/leche2.jpg" alt="Leche Deslactosada">
            <h3>Leche Deslactosada</h3>
            <p>Disfrute de la leche sin lactosa, ideal para digestiones sensibles.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/leche3.jpg" alt="Leche Semidescremada">
            <h3>Leche Semidescremada</h3>
             <p>Menos grasa, mismo sabor delicioso y nutritivo.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/leche4.jpg" alt="Leche Orgánica">
             <h3>Leche Org&aacute;nica</h3>
             <p>Leche 100% org&aacute;nica, producida con cuidados naturales.</p>
        </div>
    </section>
    <button class="carrusel-btn next">&gt;</button>
    <script src="<?= Yii::$app->request->baseUrl ?>/js/carrusel_productos.js"></script>
</div>


    <!-- Sección Quesos -->
   <div class="titulo-principal">
    <h2>Quesos</h2>
</div>

<div class="carrusel-wrapper"> 
    <button class="carrusel-btn prev" data-carrusel="2">&lt;</button>
    <section class="carrusel2">
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/queso1.jpg" alt="Queso 1">
            <h3>Queso Fresco</h3>
            <p>Queso suave y cremoso, ideal para desayunos y ensaladas.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/queso2.jpg" alt="Queso 2">
            <h3>Queso Maduro</h3>
            <p>Sabor intenso y textura firme, perfecto para tablas de quesos.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/queso3.jpg" alt="Queso Mozzarella">
            <h3>Queso Mozzarella</h3>
            <p>Queso fundente, ideal para pizzas y recetas italianas.</p>
        </div>
        <div class="card">
            <img src="<?= Yii::$app->request->baseUrl ?>/images/productos/queso4.jpg" alt="Queso 4">
            <h3>Queso Cheddar</h3>
            <p>Queso de sabor intenso y ligeramente picante, para sandwiches y gratinados.</p>
        </div>
    </section>
    <button class="carrusel-btn next" data-carrusel="2">&gt;</button>
    </div>

</main>

<footer>
    <div class="footer-container">
    <img src="<?= Yii::$app->request->baseUrl ?>/images/logos/Logo-Lacteos-Quesos-Don-Joaquin.png" class="logo-header">
        <div class="footer-col">
            <h3>L&aacute;cteos y Quesos Don Joaqu&iacute;n</h3>
            <p>Elaboramos productos artesanales con el sabor fresco que nos distingue.</p>
        </div>

        <div class="footer-col">
            <h3>Enlaces</h3>
            <ul>
                <li><a href="#home">Inicio</a></li>
                <li><a href="<?= Yii::$app->urlManager->createUrl(['site/productos']) ?>">Productos</a></li>
                <li><a href="<?= Yii::$app->urlManager->createUrl(['site/ganado']) ?>">Ganado</a></li>
                <li><a href="<?= Yii::$app->urlManager->createUrl(['site/nosotros']) ?>">Nosotros</a></li>                   
                <li><a href="<?= Yii::$app->urlManager->createUrl(['site/contactos']) ?>">Contactos</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Cont&aacute;ctanos</h3>
            <p>Tel: +507 6000-0000</p>
            <p>Email: info@donjoaquin.com</p>
            <div class="social">
                    <a href="https://www.facebook.com/donjoaquinlacteos/" target="_blank">
                    <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M17 1H7C3.69 1 1 3.69 1 7V17C1 20.31 3.69 23 7 23H17C20.31 23 23 20.31 23 17V7C23 3.69 20.31 1 17 1ZM15.5 15H13V21H10V15H8V12H10V10C10 7.86 11.23 6 14.5 6H17V9H15.5C14.12 9 14.5 9.77 14.5 10.77V12H17L16.5 15Z"/>
                    </svg>
                    </a>
    
                    <a href="https://www.instagram.com/donjoaquinlacteos/" target="_blank">
                    <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2C9.17 2 8.83 2 7.83 2.05C6.77 2.1 6.05 2.18 5.43 2.41C4.81 2.64 4.25 2.97 3.73 3.49C3.21 4.01 2.88 4.57 2.65 5.19C2.42 5.81 2.34 6.53 2.29 7.59C2.24 8.59 2.24 9.17 2.24 12C2.24 14.83 2.24 15.41 2.29 16.41C2.34 17.47 2.42 18.19 2.65 18.81C2.88 19.43 3.21 19.99 3.73 20.51C4.25 21.03 4.81 21.36 5.43 21.59C6.05 21.82 6.77 21.9 7.83 21.95C8.83 22 9.17 22 12 22C14.83 22 15.17 22 16.17 21.95C17.23 21.9 17.95 21.82 18.57 21.59C19.19 21.36 19.75 21.03 20.27 20.51C20.79 19.99 21.12 19.43 21.35 18.81C21.58 18.19 21.66 17.47 21.71 16.41C21.76 15.41 21.76 14.83 21.76 12C21.76 9.17 21.76 8.59 21.71 7.59C21.66 6.53 21.58 5.81 21.35 5.19C21.12 4.57 20.79 4.01 20.27 3.49C19.75 2.97 19.19 2.64 18.57 2.41C17.95 2.18 17.23 2.1 16.17 2.05C15.17 2 14.83 2 12 2ZM12 4C14.71 4 15.05 4 16.05 4.05C17.07 4.1 17.67 4.18 18.1 4.35C18.53 4.52 18.88 4.77 19.19 5.08C19.5 5.39 19.75 5.74 19.92 6.17C20.09 6.6 20.17 7.2 20.22 8.22C20.27 9.22 20.27 9.56 20.27 12C20.27 14.44 20.27 14.78 20.22 15.78C20.17 16.8 20.09 17.4 19.92 17.83C19.75 18.26 19.5 18.61 19.19 18.92C18.88 19.23 18.53 19.48 18.1 19.65C17.67 19.82 17.07 19.9 16.05 19.95C15.05 20 14.71 20 12 20C9.29 20 8.95 20 7.95 19.95C6.93 19.9 6.33 19.82 5.9 19.65C5.47 19.48 5.12 19.23 4.81 18.92C4.5 18.61 4.25 18.26 4.08 17.83C3.91 17.4 3.83 16.8 3.78 15.78C3.73 14.78 3.73 14.44 3.73 12C3.73 9.56 3.73 9.22 3.78 8.22C3.83 7.2 3.91 6.6 4.08 6.17C4.25 5.74 4.5 5.39 4.81 5.08C5.12 4.77 5.47 4.52 5.9 4.35C6.33 4.18 6.93 4.1 7.95 4.05C8.95 4 9.29 4 12 4ZM12 7.75C9.66 7.75 7.75 9.66 7.75 12C7.75 14.34 9.66 16.25 12 16.25C14.34 16.25 16.25 14.34 16.25 12C16.25 9.66 14.34 7.75 12 7.75ZM12 14.25C10.7 14.25 9.75 13.3 9.75 12C9.75 10.7 10.7 9.75 12 9.75C13.3 9.75 14.25 10.7 14.25 12C14.25 13.3 13.3 14.25 12 14.25ZM18.43 5.84C18.8 5.84 19.1 6.14 19.1 6.51C19.1 6.88 18.8 7.18 18.43 7.18C18.06 7.18 17.76 6.88 17.76 6.51C17.76 6.14 18.06 5.84 18.43 5.84Z"/>
                    </svg>
                    </a>
    
                    <a href="https://x.com/donjoaquinlacteos" target="_blank">
                    <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M18.9 4.2C19.1 4 19.3 4 19.5 4H22.5L16.2 11.4L23 20H17.7L12.7 13.8L7 20H4L10.9 12.3L4 4H9.3L13.8 9.5L18.9 4.2ZM18.5 18H20.1L8.3 6H6.6L18.5 18Z"/>
                    </svg>
                    </a>
                </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 L&aacute;cteos y Quesos Don Joaqu&iacute;n. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="<?= Yii::$app->request->baseUrl ?>/js/script.js"></script>