<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Registro';
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/register.css">

<div class="site-register">

    <!-- Título -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Botón para volver al Index (corregido) -->
    <button type="button" onclick="window.location.href='<?= Yii::$app->request->baseUrl ?>/site/index'">
        ← Volver
    </button>

    <p>Complete todos los campos para registrarse:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Ingrese su nombre']) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Ingrese su email']) ?>

            <?= $form->field($model, 'celular')->textInput(['placeholder' => 'Ingrese su celular']) ?>

            <?= $form->field($model, 'contrasena')->passwordInput(['placeholder' => 'Ingrese una contraseña']) ?>

            <?= $form->field($model, 'confirmar_contrasena')->passwordInput(['placeholder' => 'Confirme la contraseña']) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
