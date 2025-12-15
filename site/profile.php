<?php
/* @var $user app\models\Usuarios */
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/profile.css">


<h1>Tu Perfil</h1>

<div class="profile-container" style="max-width:600px; margin:auto; font-family: Arial, sans-serif;">

    <!-- Botón volver atrás -->
    <button onclick="window.location.href='<?= Yii::$app->request->baseUrl ?>/site/index'" style="margin-bottom:20px;">
    ← Volver
    </button>

    <!-- Mensajes de éxito/error -->
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div style="color: <?= $key === 'success' ? 'green' : 'red' ?>; font-weight:bold; margin-bottom:10px;">
            <?= $message ?>
        </div>
    <?php endforeach; ?>

    <!-- Información del usuario -->
    <div class="profile-info" style="margin-bottom:20px;">
        <p><strong>Nombre:</strong> <?= htmlspecialchars($user->nombre) ?></p>
        <p><strong>Imagen:</strong> 
            <?php if ($user->imagen): ?>
                <img src="<?= Yii::$app->request->baseUrl ?>/uploads/<?= $user->imagen ?>" alt="Perfil" style="width:100px; height:100px; object-fit:cover; border-radius:50%;">
            <?php else: ?>
                Sin imagen
            <?php endif; ?>
        </p>
        <p><strong>Celular:</strong> <?= htmlspecialchars($user->celular) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
        <p><strong>Fecha creado:</strong> <?= htmlspecialchars($user->fecha_creado) ?></p>
    </div>

    <hr>

    <!-- Cambiar contraseña -->
    <div class="change-password" style="margin-bottom:20px;">
        <h3>Cambiar contraseña</h3>
        <form id="passwordForm" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/change-password']) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <label for="newPassword">Nueva contraseña:</label><br>
            <input type="password" id="newPassword" name="newPassword" required style="margin-bottom:5px;"><br>
            <label for="confirmPassword">Repetir contraseña:</label><br>
            <input type="password" id="confirmPassword" name="confirmPassword" required style="margin-bottom:10px;"><br>
            <button type="submit">Cambiar contraseña</button>
        </form>
    </div>

    <hr>

    <!-- Cambiar imagen de perfil -->
    <div class="change-image">
        <h3>Cambiar imagen de perfil</h3>
        <form id="imageForm" enctype="multipart/form-data" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/change-profile-image']) ?>">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <input type="file" name="profileImage" accept="image/*" required style="margin-bottom:10px;"><br>
            <button type="submit">Subir imagen</button>
        </form>
    </div>
</div>

<script>
    // Validación de cambio de contraseña en el cliente
    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            event.preventDefault();
            alert('Las contraseñas no coinciden.');
        }
    });
</script>
