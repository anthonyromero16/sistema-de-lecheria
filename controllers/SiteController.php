<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\Usuarios;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionGanado()
    {
        return $this->render('ganado');
    }

    public function actionContactos()
    {
        return $this->render('contactos');
    }

    public function actionNosotros()
    {
        return $this->render('nosotros');
    }

    public function actionProductos()
    {
        return $this->render('productos');
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) &&
            $model->contact(Yii::$app->params['adminEmail'])) {

            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

   public function actionRegister()
{
    $model = new RegisterForm();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        $usuario = new Usuarios();
        $usuario->nombre = $model->nombre;
        $usuario->email = $model->email;
        $usuario->celular = $model->celular;
        $usuario->contrasena = Yii::$app->security->generatePasswordHash($model->contrasena);
        $usuario->fecha_creado = date('Y-m-d H:i:s');
        $usuario->fecha_actualizado = date('Y-m-d H:i:s');
        $usuario->rol = Usuarios::ROL_USUARIO;

        if ($usuario->save()) {
            Yii::$app->session->setFlash('success', 'Registro exitoso.');
            return $this->redirect(['login']);
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo registrar el usuario.');
        }
    }

    return $this->render('register', [
        'model' => $model,
    ]);

}

public function actionProfile()
{
    $user = Yii::$app->user->identity; // Obtiene datos del usuario logueado
    return $this->render('profile', [
        'user' => $user,
    ]);
}

// Cambiar contraseña
public function actionChangePassword()
{
    if (Yii::$app->request->isPost) {
        $user = Yii::$app->user->identity;
        $newPassword = Yii::$app->request->post('newPassword');
        $confirmPassword = Yii::$app->request->post('confirmPassword');

        if ($newPassword !== $confirmPassword) {
            Yii::$app->session->setFlash('error', 'Las contraseñas no coinciden.');
            return $this->redirect(['profile']);
        }

        $user->contrasena = Yii::$app->security->generatePasswordHash($newPassword);
        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Contraseña cambiada correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo cambiar la contraseña.');
        }

        return $this->redirect(['profile']);
    }
}

// Cambiar imagen de perfil
public function actionChangeProfileImage()
{
    if (Yii::$app->request->isPost) {
        $user = Yii::$app->user->identity;
        $uploadedFile = \yii\web\UploadedFile::getInstanceByName('profileImage');

        if ($uploadedFile) {
            $fileName = time() . '_' . $uploadedFile->name;
            $path = Yii::getAlias('@webroot/uploads/') . $fileName;

            if ($uploadedFile->saveAs($path)) {
                $user->imagen = $fileName;
                $user->save(false); // guardar sin validar otros campos
                Yii::$app->session->setFlash('success', 'Imagen de perfil actualizada.');
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo subir la imagen.');
            }
        }
        return $this->redirect(['profile']);
    }
}

public function actionProfileGanado()
{
    $user = Yii::$app->user->identity;

    // Obtenemos los animales del usuario usando id_usuario
    $ganado = \app\models\Animales::find()->where(['id_usuario' => $user->id])->all();

    // Obtenemos todas las razas para el <select>
    $razas = \app\models\Razas::find()->all();

    // Obtenemos todas las vacunas para el <select> del modal
    $vacunas = \app\models\Vacunas::find()->all();

    return $this->render('profile_ganado', [
        'user' => $user,
        'ganado' => $ganado,
        'razas' => $razas,
        'vacunas' => $vacunas, // Pasamos la variable a la vista
    
    ]);
}

public function actionAgregarAnimal()
{
    $model = new \app\models\Animales();

    if (Yii::$app->request->isPost) {
        $model->nombre = Yii::$app->request->post('nombre');
        $model->descripcion = Yii::$app->request->post('descripcion');
        $model->id_raza = Yii::$app->request->post('id_raza');
        $model->fecha_nacimiento = Yii::$app->request->post('fecha_nacimiento');
        $model->peso_kg = Yii::$app->request->post('peso_kg');
        $model->temperatura_celsius = Yii::$app->request->post('temperatura_celsius');
        $model->id_usuario = Yii::$app->user->id;

        $uploadedFile = \yii\web\UploadedFile::getInstanceByName('imagen');
        if ($uploadedFile) {
            $fileName = time() . '_' . $uploadedFile->name;
            $uploadedFile->saveAs(Yii::getAlias('@webroot/uploads/') . $fileName);
            $model->imagen = $fileName;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Animal agregado correctamente.');
            return $this->redirect(['profile-ganado']);
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo agregar el animal.');
        }
    }

    return $this->redirect(['profile-ganado']);
}

public function getRaza()
{
    return $this->hasOne(Razas::class, ['id' => 'id_razas']);
}

public function actionUpdateAnimal()
{
    $id = Yii::$app->request->post('id_animal'); // ID enviado desde el modal
    $model = \app\models\Animales::findOne($id);

    if (!$model) {
        throw new \yii\web\NotFoundHttpException("Animal no encontrado.");
    }

    // Asignar valores del formulario
    $model->nombre = Yii::$app->request->post('nombre');
    $model->descripcion = Yii::$app->request->post('descripcion');
    $model->id_raza = Yii::$app->request->post('id_raza');
    $model->fecha_nacimiento = Yii::$app->request->post('fecha_nacimiento');
    $model->peso_kg = Yii::$app->request->post('peso_kg');
    $model->temperatura_celsius = Yii::$app->request->post('temperatura_celsius');

    // Imagen opcional
    $uploadedFile = \yii\web\UploadedFile::getInstanceByName('imagen');
    if ($uploadedFile) {
        $model->imagen = file_get_contents($uploadedFile->tempName);
    }

    if ($model->save()) {
        return $this->redirect(['site/profile-ganado']); // Volver a la lista
    } else {
        // Si falla la validación, mostrar errores
        Yii::$app->session->setFlash('error', implode(', ', $model->getFirstErrors()));
        return $this->redirect(['site/profile-ganado']);
    }
}

// Producción
public function actionProduccion()
{
    $id = Yii::$app->request->post('id_animal');
    $model = new \app\models\Produccion();
    $model->id_animal = $id;
    $model->fecha_extraido = Yii::$app->request->post('fecha_extraido');
    $model->litros = Yii::$app->request->post('litros');
    $model->tipo_leche = Yii::$app->request->post('tipo_leche');

    if ($model->save()) return $this->redirect(['site/profile-ganado']);
    Yii::$app->session->setFlash('error', implode(', ', $model->getFirstErrors()));
    return $this->redirect(['site/profile-ganado']);
}

// Veterinaria
public function actionVeterinaria()
{
    $id = Yii::$app->request->post('id_animal');
    $model = new \app\models\Veterinaria();
    $model->id_animal = $id;
    $model->tipo_evento = Yii::$app->request->post('tipo_evento');
    $model->descripcion = Yii::$app->request->post('descripcion');
    $model->fecha = Yii::$app->request->post('fecha');

    if ($model->save()) return $this->redirect(['site/profile-ganado']);
    Yii::$app->session->setFlash('error', implode(', ', $model->getFirstErrors()));
    return $this->redirect(['site/profile-ganado']);
}

// Vacunas
public function actionVacunas()
{
    $id = Yii::$app->request->post('id_animal');
    $model = new \app\models\AnimalVacuna();
    $model->id_animal = $id;
    $model->id_vacuna = Yii::$app->request->post('id_vacuna');
    $model->fecha_aplicacion = Yii::$app->request->post('fecha_aplicacion'); // CORRECTO
    $model->observaciones = Yii::$app->request->post('observaciones');

    if ($model->save()) {
        return $this->redirect(['site/profile-ganado']);
    }

    Yii::$app->session->setFlash('error', implode(', ', $model->getFirstErrors()));
    return $this->redirect(['site/profile-ganado']);
}


// Ver Producción de un Animal
public function actionVerProduccion($id)
{
    $producciones = \app\models\Produccion::find()->where(['id_animal' => $id])->all();
    return $this->render('ver_produccion', ['producciones' => $producciones]);
}

public function actionGetProfileImage()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    if (Yii::$app->user->isGuest) {
        return ['url' => Yii::$app->request->baseUrl . '/images/users/default.png'];
    }

    // Consulta real a la BD
    $usuario = Usuarios::find()
        ->select(['imagen'])
        ->where(['id' => Yii::$app->user->id])
        ->one();

    if ($usuario && !empty($usuario->imagen)) {
        // La imagen existe en BD → usar esa ruta
        return [
            'url' => Yii::$app->request->baseUrl . '/uploads/' . $usuario->imagen
        ];
    }

    // Si no tiene imagen en BD → usar default
    return ['url' => Yii::$app->request->baseUrl . '/images/users/default.png'];
}

public function actionDeleteAnimal($id)
{
    $model = \app\models\Animales::findOne($id);

    if (!$model) {
        throw new \yii\web\NotFoundHttpException("Animal no encontrado.");
    }

    // Validar que el animal pertenece al usuario logueado
    if ($model->id_usuario != Yii::$app->user->id) {
        Yii::$app->session->setFlash('error', 'No tienes permiso para eliminar este animal.');
        return $this->redirect(['profile-ganado']);
    }

    if ($model->delete()) {
        Yii::$app->session->setFlash('success', 'Animal eliminado correctamente.');
    } else {
        Yii::$app->session->setFlash('error', 'Error al eliminar el animal.');
    }

    return $this->redirect(['profile-ganado']);
}



}

